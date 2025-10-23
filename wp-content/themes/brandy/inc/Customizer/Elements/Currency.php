<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\TypographyService;
use Brandy\Traits\SingletonTrait;

class Currency extends AbstractBaseElement {

	use SingletonTrait;

	protected $settings = array();

	protected $default_currencies = array();

	protected $builders = array( 'header', 'footer' );

	protected $element_id = 'currency';

	protected $title = 'Currency';

	protected $icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M14.75 6.5C10.1937 6.5 6.5 10.1937 6.5 14.75C6.5 19.3063 10.1937 23 14.75 23C19.3063 23 23 19.3063 23 14.75C23 10.1937 19.3063 6.5 14.75 6.5ZM5 14.75C5 9.36522 9.36522 5 14.75 5C20.1348 5 24.5 9.36522 24.5 14.75C24.5 20.1348 20.1348 24.5 14.75 24.5C9.36522 24.5 5 20.1348 5 14.75ZM11.9107 10.7752C12.4783 10.2707 13.231 10 14 10V8.75C14 8.33579 14.3358 8 14.75 8C15.1642 8 15.5 8.33579 15.5 8.75V10H17.75C18.1642 10 18.5 10.3358 18.5 10.75C18.5 11.1642 18.1642 11.5 17.75 11.5H14C13.5755 11.5 13.1836 11.6507 12.9073 11.8963C12.6338 12.1394 12.5 12.4489 12.5 12.75C12.5 13.0511 12.6338 13.3606 12.9073 13.6037C13.1836 13.8493 13.5755 14 14 14H15.5C16.269 14 17.0217 14.2707 17.5893 14.7752C18.1597 15.2823 18.5 15.9902 18.5 16.75C18.5 17.5098 18.1597 18.2177 17.5893 18.7248C17.0217 19.2293 16.269 19.5 15.5 19.5V19.75C15.5 20.1642 15.1642 20.5 14.75 20.5C14.3358 20.5 14 20.1642 14 19.75V19.5H11.75C11.3358 19.5 11 19.1642 11 18.75C11 18.3358 11.3358 18 11.75 18H14.1003C14.23 17.7758 14.4724 17.625 14.75 17.625C15.0276 17.625 15.27 17.7758 15.3997 18H15.5C15.9245 18 16.3164 17.8493 16.5927 17.6037C16.8662 17.3606 17 17.0511 17 16.75C17 16.4489 16.8662 16.1394 16.5927 15.8963C16.3164 15.6507 15.9245 15.5 15.5 15.5H14C13.231 15.5 12.4783 15.2293 11.9107 14.7248C11.3403 14.2177 11 13.5098 11 12.75C11 11.9902 11.3403 11.2823 11.9107 10.7752Z" fill="' . BRANDY_ICON_COLOR_NORMAL . '"/>
			</svg>
			';

	protected function __construct() {

		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );

		$this->default_currencies = $this->get_available_currencies();

		parent::__construct();
	}

	protected function register_components() {
		$typo = TypographyService::get_default_typography_value();

		return array(
			'list_currencies'                    => array(
				'value_path'    => array(),
				'default_value' => array(),
				'type'          => 'ListCurrencies',
			),
			'currency_icon_enabled'              => array(
				'value_path'     => array( 'currency_flag_enabled' ),
				'title'          => array(
					'text' => __( 'Show currency flag', 'brandy' ),
					'type' => 'bold',
				),
				'default_value'  => true,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-currency-flag',
							'value_path'        => array( 'currency_icon_enabled' ),
							'mapping_variables' => array(
								array(
									'condition' => array(
										'value'    => true,
										'operator' => 'equal',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'display' => 'flex',
										),
									),
								),
								array(
									'condition' => array(
										'value'    => false,
										'operator' => 'equal',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'display' => 'none',
										),
									),
								),
							),
						),
					),
				),
			),
			'currency_icon_position'             => array(
				'title'               => array(
					'text' => __( 'Icon Position', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'          => array( 'currency_icon_position' ),
				'type'                => 'Position',
				'default_value'       => 'left',
				'available_positions' => array( 'left', 'right' ),
				'render_options'      => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-currency-box',
							'value_path' => array( 'currency_icon_position' ),
							'name'       => 'flag-position',
						),
					),
				),
			),
			'arrow_icon_enabled'                 => array(
				'value_path'     => array( 'show_arrow_icon' ),
				'title'          => array(
					'text' => __( 'Show arrow icon', 'brandy' ),
					'type' => 'bold',
				),
				'default_value'  => true,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-currency-arrow',
							'value_path'        => array( 'show_arrow_icon' ),
							'mapping_variables' => array(
								array(
									'condition' => array(
										'value'    => true,
										'operator' => 'equal',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'display' => 'block',
										),
									),
								),
								array(
									'condition' => array(
										'value'    => false,
										'operator' => 'equal',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'display' => 'none',
										),
									),
								),
							),
						),
					),
				),
			),
			//design
			'design_symbol_reset'                => array(
				'title'       => array(
					'text'         => __( 'Currency flag', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'design_symbol' ),
				),
			),
			'design_symbol_size'                 => array(
				'title'          => array(
					'text' => __( 'Flag size', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'design_symbol', 'size' ),
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-symbol-size',
							'value_path' => array( 'design_symbol', 'size' ),
						),
					),
				),
			),
			'design_margin'                      => array(
				'value_path'     => array( 'design_margin' ),
				'title'          => array(
					'text' => 'Margin',
					'type' => 'bold',
				),
				'default_value'  => array(
					'unit'           => 'px',
					'top'            => 0,
					'right'          => 0,
					'bottom'         => 0,
					'left'           => 0,
					'is_constraints' => false,
				),
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'selector'   => '.brandy-currency-element',
							'name'       => 'margin',
							'value_path' => array( 'design_margin' ),
						),
					),
				),
			),
			'currency_item_reset'                => array(
				'type'        => 'Reset',
				'title'       => array(
					'text'         => __( 'Currency item', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'reset_paths' => array(
					array( 'currency_item' ),
				),
			),
			'currency_item_color'                => array(
				'value_path'         => array( 'currency_item', 'color' ),
				'title'              => array(
					'text' => 'Text color',
					'type' => 'normal',
				),
				'default_value'      => array(
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
				'is_responsive'      => true,
				'type'               => 'ColorGroup',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-currency-item-color',
							'selector'   => '.brandy-currency-option',
							'value_path' => array( 'currency_item', 'color' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'flag_name', 'display' ),
						'value'      => true,
					),
				),
			),
			'currency_item_typography'           => array(
				'value_path'     => array( 'currency_item', 'typography' ),
				'title'          => array(
					'text' => 'Typography',
					'type' => 'normal',
				),
				'default_value'  => TypographyService::get_value(
					array(
						'font_size' => array(
							'desktop' => array(
								'unit'  => 'px',
								'value' => 14,
							),
						),
					)
				),
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-currency-option',
							'value_path' => array( 'currency_item', 'typography' ),
						),
					),
				),
			),
			'currency_item_activator_typography' => array(
				'value_path'     => array( 'currency_item', 'activator_typography' ),
				'title'          => array(
					'text' => __( 'Active typography', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => TypographyService::get_value(
					array(
						'font_size'  => array(
							'desktop' => array(
								'unit'  => 'px',
								'value' => 14,
							),
						),
						'font_style' => array(
							'desktop' => array(
								'weight' => 600,
							),
						),
					)
				),
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-currency-option.current-currency',
							'value_path' => array( 'currency_item', 'activator_typography' ),
						),
					),
				),
			),
			'currency_item_background'           => array(
				'value_path'     => array( 'currency_item', 'background' ),
				'title'          => array(
					'text' => 'Background',
					'type' => 'normal',
				),
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#ffffff00',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#f1f3f7',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => '#f1f3f7',
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
							'name'       => '--b-currency-item-background',
							'selector'   => '.brandy-currency-option',
							'value_path' => array( 'currency_item', 'background' ),
						),
					),
				),
			),
			'currency_item_stroke_color'         => array(
				'value_path'     => array( 'currency_item', 'stroke_color' ),
				'title'          => array(
					'text' => 'Stroke color',
					'type' => 'normal',
				),
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#ffffff00',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#2170b038',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => '#2170b038',
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
							'name'       => '--b-currency-item-stroke-color',
							'selector'   => '.brandy-currency-option',
							'value_path' => array( 'currency_item', 'stroke_color' ),
						),
					),
				),
			),
			'currency_item_stroke_width'         => array(
				'value_path'     => array( 'currency_item', 'stroke_width' ),
				'title'          => array(
					'text' => 'Stroke width',
					'type' => 'normal',
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 30,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'units'          => array( 'px' ),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-currency-item-stroke-width',
							'selector'   => '.brandy-currency-option',
							'value_path' => array( 'currency_item', 'stroke_width' ),
						),
					),
				),
			),
			'currency_item_border_radius'        => array(
				'value_path'     => array( 'currency_item', 'border_radius' ),
				'title'          => array(
					'text' => 'Border radius',
					'type' => 'normal',
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 100,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'units'          => array( 'px', '%' ),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-currency-item-border-radius',
							'selector'   => '.brandy-currency-option',
							'value_path' => array( 'currency_item', 'border_radius' ),
						),
					),
				),
			),
			'currency_item_spacing'              => array(
				'value_path'     => array( 'currency_item', 'spacing' ),
				'title'          => array(
					'text' => 'Item Spacing',
					'type' => 'normal',
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 24,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'units'          => array( 'px' ),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => 'gap',
							'selector'   => '.brandy-currency-options',
							'value_path' => array( 'currency_item', 'spacing' ),
						),
					),
				),
			),
			'currency_item_padding'              => array(
				'value_path'     => array( 'currency_item', 'padding' ),
				'title'          => array(
					'text' => __( 'Item padding', 'brandy' ),
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 8,
						'right'          => 16,
						'bottom'         => 8,
						'left'           => 16,
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
							'name'       => 'padding',
							'selector'   => '.brandy-currency-option',
							'value_path' => array( 'currency_item', 'padding' ),
						),
					),
				),
			),
			'dropdown_reset'                     => array(
				'title'       => array(
					'text'         => __( 'Dropdown', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array(
						'dropdown_padding',
						'activator',
					),
					array(
						'activator',
					),
				),
			),
			'activator_background'               => array(
				'value_path'     => array( 'activator', 'background' ),
				'title'          => array(
					'text' => __( 'Background', 'brandy' ),
					'type' => 'normal',
				),
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
					// 'active' => array(
					// 	'desktop' => '#2170b014',
					// 	'tablet'  => null,
					// 	'mobile'  => null,
					// ),
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-activator-background',
							'selector'   => '.brandy-currency-switcher__placeholder',
							'value_path' => array( 'activator', 'background' ),
						),
					),
				),
			),
			'activator_stroke_color'             => array(
				'value_path'     => array( 'activator', 'stroke_color' ),
				'title'          => array(
					'text' => __( 'Stroke color', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#ffffff',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#2170b038',
						'tablet'  => null,
						'mobile'  => null,
					),
					// 'active' => array(
					// 	'desktop' => '#2170b038',
					// 	'tablet'  => null,
					// 	'mobile'  => null,
					// ),
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-activator-stroke-color',
							'selector'   => '.brandy-currency-switcher__placeholder',
							'value_path' => array( 'activator', 'stroke_color' ),
						),
					),
				),
			),
			'activator_stroke_width'             => array(
				'value_path'     => array( 'activator', 'stroke_width' ),
				'title'          => array(
					'text' => __( 'Stroke width', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 30,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'units'          => array( 'px' ),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-activator-stroke-width',
							'selector'   => '.brandy-currency-switcher__placeholder',
							'value_path' => array( 'activator', 'stroke_width' ),
						),
					),
				),
			),
			'activator_border_radius'            => array(
				'value_path'     => array( 'activator', 'border_radius' ),
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 100,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'units'          => array( 'px', '%' ),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-activator-border-radius',
							'selector'   => '.brandy-currency-switcher__placeholder',
							'value_path' => array( 'activator', 'border_radius' ),
						),
					),
				),
			),
			'activator_padding'                  => array(
				'value_path'     => array( 'activator', 'padding' ),
				'title'          => array(
					'text' => __( 'Padding', 'brandy' ),
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
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
							'name'       => 'padding',
							'selector'   => '.brandy-currency-switcher__placeholder',
							'value_path' => array( 'activator', 'padding' ),
						),
					),
				),
			),
			'activator_typography'               => array(
				'value_path'     => array( 'activator', 'typography' ),
				'title'          => array(
					'text' => __( 'Typography', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => TypographyService::get_value(
					array(
						'font_size'  => array(
							'desktop' => array(
								'unit'  => 'px',
								'value' => 14,
							),
						),
						'font_style' => array(
							'desktop' => array(
								'weight' => 500,
							),
						),
					)
				),
				'is_responsive'  => true,
				'type'           => 'Typography',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-currency-switcher__placeholder',
							'value_path' => array( 'activator', 'typography' ),
						),
					),
				),
			),
			'activator_color'                    => array(
				'value_path'     => array( 'activator', 'color' ),
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
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
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-activator-color',
							'selector'   => '.brandy-currency-switcher__placeholder',
							'value_path' => array( 'activator', 'color' ),
						),
					),
				),
			),
			'dropdown_padding'                   => array(
				'value_path'     => array( 'dropdown_padding' ),
				'title'          => array(
					'text' => __( 'Dropdown padding', 'brandy' ),
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 3,
						'right'          => 0,
						'bottom'         => 3,
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
							'selector'   => '.brandy-currency-options',
							'name'       => 'padding',
							'value_path' => array( 'dropdown_padding' ),
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
							'list_currencies',
						),
					),
					array(
						'components' => array(
							'currency_icon_enabled',
							'currency_icon_position',
						),
					),
					array(
						'components' => array(
							'arrow_icon_enabled',
						),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array(
							'design_symbol_reset',
							'design_symbol_size',
						),
					),
					array(
						'components' => array(
							'dropdown_reset',
							'dropdown_padding',
							'activator_background',
							'activator_stroke_color',
							'activator_stroke_width',
							'activator_border_radius',
							'activator_padding',
							'activator_typography',
							'activator_color',
						),
					),
					array(
						'components' => array(
							'currency_item_reset',
							'currency_item_typography',
							'currency_item_activator_typography',
							'currency_item_background',
							'currency_item_stroke_color',
							'currency_item_stroke_width',
							'currency_item_border_radius',
							'currency_item_spacing',
							'currency_item_padding',
						),
					),
					array(
						'components' => array(
							'design_margin',
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
		$localize_data['currency'] = array(
			'list' => $this->get_available_currencies(),
		);
		return $localize_data;
	}
	public function get_available_currencies() {
		if ( class_exists( 'Yay_Currency\Helpers\Helper' ) ) {
			$currencies = apply_filters( 'yay_currency_get_currencies_posts', \Yay_Currency\Helpers\Helper::get_currencies_post_type() );
			$res        = array();
			foreach ( $currencies as $currency ) {
				$code  = $currency->post_title;
				$res[] = array(
					'id'     => $code,
					'name'   => $currency->post_title,
					'flag'   => self::get_currency_flag( $code ),
					'symbol' => get_woocommerce_currency_symbol( $code ),
					'yay_id' => $currency->ID,
				);
			}
			return $res;
		}
		return null;
	}

	public static function get_currency_flag( $code ) {
		$countries_code = array();
		$flag           = '';
		if ( class_exists( '\Yay_Currency\Helpers\Helper' ) ) {
			if ( is_callable( array( '\Yay_Currency\Helpers\Helper', 'currency_code_by_country_code' ) ) ) {
				$countries_code = \Yay_Currency\Helpers\Helper::currency_code_by_country_code();
			}
			if ( is_callable( array( '\Yay_Currency\Helpers\CountryHelper', 'currency_code_by_country_code' ) ) ) {
				$countries_code = \Yay_Currency\Helpers\CountryHelper::currency_code_by_country_code();
			}
			$selected_country_code = $countries_code[ $code ] ?? null;
			if ( ! empty( $selected_country_code ) && is_callable( array( '\Yay_Currency\Helpers\Helper', 'get_flag_by_country_code' ) ) ) {
				$flag = \Yay_Currency\Helpers\Helper::get_flag_by_country_code( $selected_country_code );
			}
			if ( ! empty( $selected_country_code ) && is_callable( array( '\Yay_Currency\Helpers\CountryHelper', 'get_flag_by_country_code' ) ) ) {
				$flag = \Yay_Currency\Helpers\CountryHelper::get_flag_by_country_code( $selected_country_code );
			}
		}
		return $flag;
	}
}
