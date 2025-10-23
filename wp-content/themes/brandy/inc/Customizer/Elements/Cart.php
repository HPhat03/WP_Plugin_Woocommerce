<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\TypographyService;
use Brandy\Traits\SingletonTrait;

class Cart extends AbstractBaseElement {

	use SingletonTrait;

	protected $components = array();

	protected $element_id = 'cart';

	protected $title = 'Cart';

	public static $path_to_icons = BRANDY_TEMPLATE_DIR . '/template-parts/icons/cart/';

	protected $icon = '<svg
			width="30"
			height="30"
			viewBox="0 0 30 30"
			fill="none"
			xmlns="http://www.w3.org/2000/svg"
		  >
			<path
			  fillRule="evenodd"
			  clipRule="evenodd"
			  d="M11.5365 6.25L11.4884 6.25H11.4884C10.6876 6.24997 10.016 6.24995 9.47655 6.31873C8.90519 6.39157 8.38626 6.55118 7.94675 6.93977C7.50723 7.32836 7.28524 7.82383 7.14294 8.38195C7.00858 8.90896 6.92632 9.57543 6.82823 10.3702L6.82233 10.418L5.80999 18.618L5.80316 18.6733C5.67974 19.6727 5.57746 20.501 5.58836 21.1614C5.59981 21.8553 5.73549 22.494 6.20187 23.0215C6.66824 23.549 7.28553 23.7619 7.97283 23.8583C8.62693 23.9501 9.46146 23.95 10.4685 23.95H10.4685H10.5242H11H19H19.4758H19.5315H19.5315C20.5385 23.95 21.3731 23.9501 22.0272 23.8583C22.7145 23.7619 23.3318 23.549 23.7981 23.0215C24.2645 22.494 24.4002 21.8553 24.4116 21.1614C24.4225 20.501 24.3203 19.6727 24.1969 18.6734L24.1968 18.6733L24.19 18.618L23.1777 10.418L23.1718 10.3703C23.0737 9.57546 22.9914 8.90897 22.8571 8.38195C22.7148 7.82383 22.4928 7.32836 22.0533 6.93977C21.6137 6.55118 21.0948 6.39157 20.5234 6.31873C19.984 6.24995 19.3124 6.24997 18.5116 6.25H18.5116L18.4635 6.25H18H12H11.5365ZM8.9403 8.06353C9.06818 7.95047 9.25388 7.85926 9.66625 7.80669C10.0997 7.75143 10.6749 7.75 11.5365 7.75H12H18H18.4635C19.3251 7.75 19.9003 7.75143 20.3338 7.80669C20.7461 7.85926 20.9318 7.95047 21.0597 8.06353C21.1876 8.17659 21.3009 8.34972 21.4036 8.75254C21.5115 9.17596 21.5834 9.74664 21.689 10.6018L22.7013 18.8018C22.8333 19.8707 22.9208 20.5938 22.9118 21.1366C22.9032 21.658 22.805 21.8802 22.6744 22.028C22.5437 22.1757 22.3353 22.3004 21.8188 22.3729C21.2812 22.4483 20.5528 22.45 19.4758 22.45H19H11H10.5242C9.44721 22.45 8.71876 22.4483 8.18116 22.3729C7.66473 22.3004 7.45627 22.1757 7.32563 22.028C7.19499 21.8802 7.09676 21.658 7.08816 21.1366C7.0792 20.5938 7.16672 19.8707 7.29868 18.8018L8.31103 10.6018C8.4166 9.74663 8.48849 9.17595 8.59645 8.75254C8.69915 8.34972 8.81243 8.17659 8.9403 8.06353ZM11.7238 14.6511C12.6103 15.431 13.7938 15.8538 15.0097 15.8496C17.5034 15.8489 19.6875 14.0438 19.6875 11.6282C19.6875 11.214 19.3517 10.8782 18.9375 10.8782C18.5233 10.8782 18.1875 11.214 18.1875 11.6282C18.1875 13.0466 16.8541 14.3496 15.0083 14.3496H15.0055C14.132 14.3529 13.3087 14.0477 12.7146 13.5249C12.1235 13.0049 11.8125 12.3197 11.8125 11.6282C11.8125 11.214 11.4767 10.8782 11.0625 10.8782C10.6483 10.8782 10.3125 11.214 10.3125 11.6282C10.3125 12.7831 10.834 13.8683 11.7238 14.6511Z"
			  fill="' . BRANDY_ICON_COLOR_NORMAL . '"
			/>
		  </svg>';

	protected function __construct() {
		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );
		parent::__construct();
	}

	/**
	 * Override base element
	 *
	 * @Override
	 */
	protected function register_components() {
		$arr = array(
			'icon'                                     => array(
				'value_path'     => array( 'icon' ),
				'default_value'  => 'cart_1',
				'title'          => array(
					'text' => __( 'Select cart icon', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'CartIconSelection',
				'options'        => array(
					array(
						'value' => 'cart_1',
					),
					array(
						'value' => 'cart_2',
					),
					array(
						'value' => 'cart_3',
					),
					array(
						'value' => 'cart_4',
					),
					array(
						'value' => 'cart_5',
					),
				),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'icon_style'                               => array(
				'title'          => array(
					'text' => __( 'Icon style', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'icon_style' ),
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'label' => 'Bold',
						'value' => 'bold',
					),
					array(
						'label' => 'Outline',
						'value' => 'outline',
					),
				),
				'default_value'  => 'outline',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'label_enable'                             => array(
				'title'          => array(
					'text'         => __( 'Show label', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'description'    => __( 'Label will be shown as a tooltip on hover in desktop mode if this setting is OFF.', 'brandy' ),
				'type'           => 'Switcher',
				'value_path'     => array( 'label', 'display' ),
				'default_value'  => array(
					'desktop' => false,
					'tablet'  => true,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-cart-label',
							'name'           => 'class',
							'enabled_class'  => '',
							'disabled_class' => 'is-tooltip',
							'value_path'     => array( 'label', 'display', 'desktop' ),
						),
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-cart-label',
							'name'           => 'class',
							'value_path'     => array( 'label', 'display', 'tablet' ),
							'enabled_class'  => '',
							'disabled_class' => 'hidden-md',
						),
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-cart-label',
							'name'           => 'class',
							'value_path'     => array( 'label', 'display', 'mobile' ),
							'enabled_class'  => '',
							'disabled_class' => 'hidden-sm',
						),
					),
				),
			),
			'label_text'                               => array(
				'value_path'     => array( 'cart_label' ),
				'type'           => 'TextInput',
				'default_value'  => 'Cart',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-cart-label',
							'value_path' => array( 'cart_label' ),
						),
					),
				),
			),
			'label_position'                           => array(
				'title'              => array(
					'text'         => __( 'Label position', 'brandy' ),
					'type'         => 'normal',
					'show_devices' => true,
				),
				'type'               => 'Position',
				'default_value'      => array(
					'desktop' => 'left',
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'         => array( 'label', 'position' ),
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-cart-a',
							'value_path'        => array( 'label', 'position' ),
							'mapping_variables' =>
							array_merge(
								array_map(
									function( $device ) {
										return array(
											'condition' => array(
												'operator' => 'equal',
												'value'    => 'left',
											),
											'path'      => array( $device ),
											'mapping'   => array(
												$device => array(
													'flex-direction' => 'row-reverse',
												),
											),
										);
									},
									brandy_get_devices()
								),
								array_map(
									function( $device ) {
										return array(
											'condition' => array(
												'operator' => 'equal',
												'value'    => 'right',
											),
											'path'      => array( $device ),
											'mapping'   => array(
												$device => array(
													'flex-direction' => 'row',
												),
											),
										);
									},
									brandy_get_devices()
								),
								array_map(
									function( $device ) {
										return array(
											'condition' => array(
												'operator' => 'equal',
												'value'    => 'bottom',
											),
											'path'      => array( $device ),
											'mapping'   => array(
												$device => array(
													'flex-direction' => 'column',
												),
											),
										);
									},
									brandy_get_devices()
								)
							),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'label', 'display' ),
						'value'      => true,
					),
				),
			),
			'click_effect'                             => array(
				'title'          => array(
					'text' => __( 'Cart click behavior', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'click_effect' ),
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'label' => 'Dropdown',
						'value' => 'dropdown',
					),
					array(
						'label' => 'Slide-in',
						'value' => 'slide_in',
					),
					array(
						'label' => 'Cart Page',
						'value' => 'cart_page',
					),
				),
				'default_value'  => 'dropdown',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'open_direction'                           => array(
				'title'          => array(
					'text' => __( 'Open direction', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'label' => 'From left',
						'value' => 'left',
					),
					array(
						'label' => 'From right',
						'value' => 'right',
					),
				),
				'default_value'  => 'right',
				'value_path'     => array( 'open_direction' ),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'name'           => 'data-open-direction',
							'selector'       => '.brandy-cart-drawer',
							'value_path'     => array( 'open_direction' ),
						),
					),
				),
			),
			'show_qty_badge'                           => array(
				'value_path'     => array( 'show_badge' ),
				'title'          => array(
					'text' => __( 'Show quantity badge', 'brandy' ),
					'type' => 'bold',
				),
				'default_value'  => true,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'name'           => 'display',
							'selector'       => '.brandy-cart-qtybadge',
							'value_path'     => array( 'show_badge' ),
							'type'           => 'switcher',
							'enabled_value'  => 'flex',
							'disabled_value' => 'none',
						),
					),
				),
			),
			'auto_open_mini_cart'                      => array(
				'value_path'     => array( 'auto_open_mini_cart' ),
				'title'          => array(
					'text' => __( 'Auto open mini cart', 'brandy' ),
					'type' => 'bold',
				),
				'description'    => __( 'Automatically open mini cart when new item is added', 'brandy' ),
				'default_value'  => true,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'name'           => 'data-auto-open-mini-cart',
							'value_path'     => array( 'auto_open_mini_cart' ),
							'type'           => 'switcher',
							'enabled_value'  => 'true',
							'disabled_value' => 'false',
						),
					),
				),
			),
			//designs tab
			'icon_reset'                               => array(
				'title'       => array(
					'text'         => __( 'Icon cart', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'icon_design' ),
				),
			),
			'icon_design_color'                        => array(
				'title'          => array(
					'text' => __( 'Color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon_design', 'color' ),
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
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-cart-icon-wrap',
							'name'       => '--b-icon-color',
							'value_path' => array( 'icon_design', 'color' ),
						),
					),
				),
			),
			'icon_design_background_color'             => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon_design', 'background' ),
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
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-cart-icon-wrap',
							'name'       => '--b-icon-background-color',
							'value_path' => array( 'icon_design', 'background' ),
						),
					),
				),
			),
			'icon_design_stroke_color'                 => array(
				'title'          => array(
					'text' => __( 'Stroke color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon_design', 'stroke', 'color' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--brandy-border)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--brandy-border)',
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
							'selector'   => '.brandy-cart-icon-wrap',
							'name'       => '--b-icon-stroke-color',
							'value_path' => array( 'icon_design', 'stroke', 'color' ),
						),
					),
				),
			),
			'icon_design_stroke_width'                 => array(
				'title'          => array(
					'text' => __( 'Stroke width', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon_design', 'stroke', 'width' ),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 20,
						'value' => 0,
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
							'name'       => '--b-icon-stroke-width',
							'selector'   => '.brandy-cart-icon-wrap',
							'value_path' => array( 'icon_design', 'stroke', 'width' ),
						),
					),
				),
			),
			'icon_design_border_radius'                => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon_design', 'border_radius' ),
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 100,
						'value' => 0,
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
							'name'       => '--b-icon-border-radius',
							'selector'   => '.brandy-cart-icon-wrap',
							'value_path' => array( 'icon_design', 'border_radius' ),
						),
					),
				),
			),
			'icon_design_size'                         => array(
				'title'          => array(
					'text' => __( 'Icon size', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon_design', 'size' ),
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-icon-size',
							'value_path' => array( 'icon_design', 'size' ),
						),
					),
				),
			),
			//label design
			'label_reset'                              => array(
				'title'       => array(
					'text'         => __( 'Label', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'label_design' ),
				),
			),
			'label_design_typography'                  => array(
				'value_path'     => array( 'label_design', 'typography' ),
				'title'          => array(
					'text' => 'Typography',
					'type' => 'normal',
				),
				'default_value'  => null,
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-cart-label',
							'value_path' => array( 'label_design', 'typography' ),
						),
					),
				),
			),
			'label_design_text_color'                  => array(
				'title'          => array(
					'text' => __( 'Text Color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'label_design', 'text_color' ),
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
							'name'       => '--b-label-text_color',
							'value_path' => array( 'label_design', 'text_color' ),
						),
					),
				),
			),
			'icon_close_reset'                         => array(
				'title'       => array(
					'text'         => __( 'Panel close', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'icon_close_panel_design' ),
				),
			),
			'icon_close_panel_design_color'            => array(
				'title'          => array(
					'text' => __( 'Icon Color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon_close_panel_design', 'color' ),
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
							'name'       => '--b-icon-close-color',
							'value_path' => array( 'icon_close_panel_design', 'color' ),
						),
					),
				),
			),
			// 'icon_close_panel_design_background_color' => array(
			// 	'title'          => array(
			// 		'text' => __( 'Background', 'brandy' ),
			// 		'type' => 'normal',
			// 	),
			// 	'value_path'     => array( 'icon_close_panel_design', 'background_color' ),
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
			// 	'type'           => 'ColorGroup',
			// 	'render_options' => array(
			// 		'type' => 'variable',
			// 		'data' => array(
			// 			array(
			// 				'type'       => 'color',
			// 				'name'       => '--b-icon-close-background-color',
			// 				'value_path' => array( 'icon_close_panel_design', 'background_color' ),
			// 			),
			// 		),
			// 	),
			// ),
			// 'icon_close_panel_design_stroke_color'     => array(
			// 	'title'          => array(
			// 		'text' => __( 'Stroke Color', 'brandy' ),
			// 		'type' => 'normal',
			// 	),
			// 	'value_path'     => array( 'icon_close_panel_design', 'stroke', 'color' ),
			// 	'default_value'  => array(
			// 		'normal' => array(
			// 			'desktop' => 'var(--wp--preset--color--brandy-border)',
			// 			'tablet'  => null,
			// 			'mobile'  => null,
			// 		),
			// 		'hover'  => array(
			// 			'desktop' => 'var(--wp--preset--color--brandy-border)',
			// 			'tablet'  => null,
			// 			'mobile'  => null,
			// 		),
			// 	),
			// 	'type'           => 'ColorGroup',
			// 	'render_options' => array(
			// 		'type' => 'variable',
			// 		'data' => array(
			// 			array(
			// 				'type'       => 'color',
			// 				'name'       => '--b-icon-close-stroke-color',
			// 				'value_path' => array( 'icon_close_panel_design', 'stroke', 'color' ),
			// 			),
			// 		),
			// 	),
			// ),
			// 'icon_close_panel_design_stroke_width'     => array(
			// 	'title'          => array(
			// 		'text' => 'Stroke width',
			// 		'type' => 'normal',
			// 	),
			// 	'value_path'     => array( 'icon_close_panel_design', 'stroke', 'width' ),
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
			// 	'type'           => 'Dimension',
			// 	'render_options' => array(
			// 		'type' => 'variable',
			// 		'data' => array(
			// 			array(
			// 				'type'       => 'dimension',
			// 				'selector'   => '.brandy-mini-cart__close',
			// 				'name'       => 'border-width',
			// 				'value_path' => array( 'icon_close_panel_design', 'stroke', 'width' ),
			// 			),
			// 		),
			// 	),
			// ),
			// 'icon_close_panel_design_border_radius'    => array(
			// 	'title'          => array(
			// 		'text' => 'Border radius',
			// 		'type' => 'normal',
			// 	),
			// 	'value_path'     => array( 'icon_close_panel_design', 'border_radius' ),
			// 	'units'          => array( 'px', '%' ),
			// 	'default_value'  => array(
			// 		'desktop' => array(
			// 			'unit'  => 'px',
			// 			'value' => 1,
			// 			'min'   => 0,
			// 			'max'   => 30,
			// 		),
			// 		'tablet'  => null,
			// 		'mobile'  => null,
			// 	),
			// 	'type'           => 'Dimension',
			// 	'render_options' => array(
			// 		'type' => 'variable',
			// 		'data' => array(
			// 			array(
			// 				'type'       => 'dimension',
			// 				'selector'   => '.brandy-mini-cart__close',
			// 				'name'       => 'border-radius',
			// 				'value_path' => array( 'icon_close_panel_design', 'border_radius' ),
			// 			),
			// 		),
			// 	),
			// ),
			'icon_close_panel_design_size'             => array(
				'title'          => array(
					'text' => 'Icon Size',
					'type' => 'normal',
				),
				'value_path'     => array( 'icon_close_panel_design', 'size' ),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(
						array(
							'value' => 20,
							'min'   => 15,
						)
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
							'name'       => '--b-icon-close-size',
							'value_path' => array( 'icon_close_panel_design', 'size' ),
						),
					),
				),
			),
			//qty badge
			'qtybadge_reset'                           => array(
				'title'       => array(
					'text'         => __( 'Quantity badge', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'quantify_badge_design' ),
				),
			),
			'qtybadge_design_textcolor'                => array(
				'title'          => array(
					'text' => __( 'Text Color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'qtybadge_design', 'textcolor' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#fff',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#fff',
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
							'selector'   => '.brandy-cart-qtybadge',
							'name'       => '--b-color',
							'value_path' => array( 'qtybadge_design', 'textcolor' ),
						),
					),
				),
			),
			'qtybadge_design_bgcolor'                  => array(
				'title'          => array(
					'text' => __( 'Background Color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'qtybadge_design', 'bgcolor' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary)',
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
							'name'       => '--b-bg-color',
							'selector'   => '.brandy-cart-qtybadge',
							'value_path' => array( 'qtybadge_design', 'bgcolor' ),
						),
					),
				),
			),
			'qtybadge_design_offset_top'               => array(
				'value_path'     => array( 'qtybadge_design', 'offset_top' ),
				'title'          => array(
					'text' => __( 'Offset top', 'brandy' ),
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => -50,
						'max'   => 50,
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
							'name'       => 'top',
							'selector'   => '.brandy-cart-qtybadge',
							'value_path' => array( 'qtybadge_design', 'offset_top' ),
						),
					),
				),
			),
			'qtybadge_design_offset_right'             => array(
				'value_path'     => array( 'qtybadge_design', 'offset_right' ),
				'title'          => array(
					'text' => __( 'Offset right', 'brandy' ),
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => -50,
						'max'   => 50,
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
							'name'       => 'right',
							'selector'   => '.brandy-cart-qtybadge',
							'value_path' => array( 'qtybadge_design', 'offset_right' ),
						),
					),
				),
			),
			//item spacing
			'item_spacing_design'                      => array(
				'value_path'     => array( 'item_spacing_design' ),
				'title'          => array(
					'text' => 'Item Spacing',
					'type' => 'bold',
				),
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
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-item-spacing',
							'value_path' => array( 'item_spacing_design' ),
						),
					),
				),
			),
			//padding
			'padding_design'                           => array(
				'value_path'     => array( 'padding_design' ),
				'title'          => array(
					'text'         => 'Padding',
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
				'units'          => array( 'px', '%' ),
				'render_options' => array(
					'type' => 'force_refresh',
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'selector'   => '.brandy-cart-a',
							'name'       => 'padding',
							'value_path' => array( 'padding_design' ),
						),
					),
				),
			),
			//margin
			'margin_design'                            => array(
				'value_path'     => array( 'margin_design' ),
				'title'          => array(
					'text'         => 'Margin',
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
				'units'          => array( 'px', '%' ),
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'selector'   => '.brandy-cart-a',
							'name'       => 'margin',
							'value_path' => array( 'margin_design' ),
						),
					),
				),
			),
		);

		return $arr;
	}
	public function add_layout( $layouts = array() ) {
		$layout                       = array(
			'general' => array(
				'sections' => array(
					array(
						'components' => array( 'icon' ),
					),
					array(
						'components' => array( 'icon_style' ),
					),
					array(
						'components' => array( 'label_enable', 'label_text', 'label_position' ),
					),
					array(
						'components' => array( 'click_effect' ),
					),
					array(
						'components' => array( 'show_qty_badge' ),
					),
					array(
						'components'         => array( 'auto_open_mini_cart' ),
						'visible_conditions' => array(
							'relation' => 'OR',
							array(
								'value_path' => array( 'click_effect' ),
								'value'      => 'slide_in',
							),
							array(
								'value_path' => array( 'click_effect' ),
								'value'      => 'dropdown',
							),
						),
					),
					array(
						'components'         => array( 'open_direction' ),
						'visible_conditions' => array(
							'relation' => 'OR',
							array(
								'value_path' => array( 'click_effect' ),
								'value'      => 'slide_in',
							),
						),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array(
							'icon_reset',
							'icon_design_color',
							'icon_design_background_color',
							'icon_design_stroke_color',
							'icon_design_stroke_width',
							'icon_design_border_radius',
							'icon_design_size',
						),
					),
					array(
						'components'         => array(
							'label_reset',
							'label_design_typography',
							'label_design_text_color',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'label', 'display' ),
								'value'      => true,
							),
						),
					),
					array(
						'components' => array(
							'icon_close_reset',
							'icon_close_panel_design_color',
							// 'icon_close_panel_design_background_color',
							// 'icon_close_panel_design_stroke_color',
							// 'icon_close_panel_design_stroke_width',
							// 'icon_close_panel_design_border_radius',
							'icon_close_panel_design_size',
						),
					),
					array(
						'components'         => array(
							'qtybadge_reset',
							'qtybadge_design_textcolor',
							'qtybadge_design_bgcolor',
							'qtybadge_design_offset_top',
							'qtybadge_design_offset_right',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'show_badge' ),
								'value'      => true,
							),
						),
					),
					array(
						'visible_conditions' => array(
							array(
								'value_path' => array( 'cart_name', 'enabled' ),
								'value'      => true,
							),
						),
						'components'         => array(
							'item_spacing_design',
						),
					),
					array(
						'components' => array(
							'padding_design',
						),
					),
					array(
						'components' => array(
							'margin_design',
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
		$icons  = array();
		$styles = array( 'bold', 'outline' );
		foreach ( $styles as $style ) {
			$dir             = new \DirectoryIterator( self::$path_to_icons . $style );
			$icons[ $style ] = array();
			$dirs            = array();
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
				$file_path = self::$path_to_icons . "$style/$file_name";
				$icon_name = basename( $file_name, '.php' );
				ob_start();
				require $file_path;
				$icon_data = ob_get_contents();
				ob_end_clean();
				$icons[ $style ][ $icon_name ] = $icon_data;
			}

			$localize_data['icons']['cart'] = $icons;
		}
		return $localize_data;
	}

	public static function get_icon( $icon_type, $icon_style ) {
		$file_path = self::$path_to_icons . "$icon_style/$icon_type.php";
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
