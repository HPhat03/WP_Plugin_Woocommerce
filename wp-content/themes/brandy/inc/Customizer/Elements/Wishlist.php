<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\TypographyService;
use Brandy\Traits\SingletonTrait;

class Wishlist extends AbstractBaseElement {

	use SingletonTrait;

	protected $element_id = 'wishlist';

	protected $default_contacts = array();

	public static $path_to_icons = '/template-parts/icons/wishlist/';

	protected $title = 'Wishlist';

	protected $icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M22.612 8.35263C22.1722 7.92381 21.65 7.58363 21.0752 7.35155C20.5005 7.11946 19.8844 7 19.2623 7C18.6401 7 18.0241 7.11946 17.4493 7.35155C16.8746 7.58363 16.3524 7.92381 15.9126 8.35263L14.9998 9.24217L14.087 8.35263C13.1986 7.48684 11.9936 7.00045 10.7372 7.00045C9.48085 7.00045 8.27591 7.48684 7.38751 8.35263C6.4991 9.21842 6 10.3927 6 11.6171C6 12.8415 6.4991 14.0158 7.38751 14.8815L8.30029 15.7711L14.9998 22.3L21.6992 15.7711L22.612 14.8815C23.0521 14.4529 23.4011 13.944 23.6393 13.3839C23.8774 12.8238 24 12.2234 24 11.6171C24 11.0108 23.8774 10.4104 23.6393 9.85029C23.4011 9.29016 23.0521 8.78125 22.612 8.35263V8.35263Z" stroke="' . BRANDY_ICON_COLOR_NORMAL . '" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
			';

	protected function __construct() {
		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );

		parent::__construct();
	}

	protected function register_components() {
		return array(
			'icon_title'                               => array(
				'title'   => array(
					'text' => __( 'Wishlist icon', 'brandy' ),
					'type' => 'bold',
				),
				'type'    => 'FlexibleContent',
				'content' => '',
			),
			'select_icon'                              => array(
				'title'          => array(
					'text' => __( 'Select icon', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'WishlistIconSelection',
				'value_path'     => array( 'icon_type' ),
				'default_value'  => 'a-heart',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'icon_style'                               => array(
				'title'          => array(
					'text' => __( 'Icon style', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ButtonGroup',
				'value_path'     => array( 'icon_style' ),
				'default_value'  => 'outline',
				'options'        => array(
					array(
						'label' => __( 'Bold', 'brandy' ),
						'value' => 'bold',
					),
					array(
						'label' => __( 'Outline', 'brandy' ),
						'value' => 'outline',
					),
				),
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
							'selector'       => '.brandy-wishlist-label',
							'name'           => 'class',
							'enabled_class'  => '',
							'disabled_class' => 'is-tooltip',
							'value_path'     => array( 'label', 'display', 'desktop' ),
						),
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-wishlist-label',
							'name'           => 'class',
							'value_path'     => array( 'label', 'display', 'tablet' ),
							'enabled_class'  => '',
							'disabled_class' => 'hidden-md',
						),
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-wishlist-label',
							'name'           => 'class',
							'value_path'     => array( 'label', 'display', 'mobile' ),
							'enabled_class'  => '',
							'disabled_class' => 'hidden-sm',
						),
					),
				),
			),
			'add_label'                                => array(
				'type'           => 'TextInput',
				'value_path'     => array( 'label', 'content' ),
				'default_value'  => 'Wishlist',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-wishlist__label',
							'value_path' => array( 'label', 'content' ),
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
							'selector'          => '.brandy-wishlist',
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
					'text' => __( 'Wishlist click effect', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'ButtonGroup',
				'value_path'     => array( 'click_effect' ),
				'default_value'  => 'slide_in',
				'options'        => array(
					array(
						'label' => __( 'Dropdown', 'brandy' ),
						'value' => 'dropdown',
					),
					array(
						'label' => __( 'Slide-in', 'brandy' ),
						'value' => 'slide_in',
					),
					array(
						'label' => __( 'Page', 'brandy' ),
						'value' => 'page',
					),
				),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'slide_position'                           => array(
				'title'               => array(
					'text' => __( 'Slide position', 'brandy' ),
					'type' => 'normal',
				),
				'type'                => 'Position',
				'available_positions' => array(
					'left',
					'right',
				),
				'value_path'          => array( 'slide_position' ),
				'default_value'       => 'right',
				'render_options'      => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '',
							'name'       => 'slide-position',
							'value_path' => array( 'slide_position' ),
						),
					),
				),
				'visible_conditions'  => array(
					array(
						'value_path' => array( 'click_effect' ),
						'value'      => 'slide_in',
					),
				),
			),
			'show_badge_number'                        => array(
				'title'          => array(
					'text' => __( 'Show badge number', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'default_value'  => true,
				'value_path'     => array( 'display_badge' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-count-badge',
							'value_path'        => array( 'display_badge' ),
							'mapping_variables' => array(
								array(
									'condition' => array(
										'operator' => 'equal',
										'value'    => true,
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
										'operator' => 'equal',
										'value'    => false,
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
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-count-badge[device="tablet"]',
							'name'           => 'display',
							'value_path'     => array( 'show_badge', 'tablet' ),
							'enabled_value'  => 'show',
							'disabled_value' => 'hide',
						),
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-count-badge[device="mobile"]',
							'name'           => 'display',
							'value_path'     => array( 'show_badge', 'mobile' ),
							'enabled_value'  => 'show',
							'disabled_value' => 'hide',
						),
					),
				),
			),
			'show_product_type'                        => array(
				'title'          => array(
					'text' => __( 'Show product type', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'ButtonGroup',
				'value_path'     => array( 'show_product_type' ),
				'default_value'  => 'list_view',
				'options'        => array(
					array(
						'label' => __( 'Grid view', 'brandy' ),
						'value' => 'grid_view',
					),
					array(
						'label' => __( 'List view', 'brandy' ),
						'value' => 'list_view',
					),
				),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '',
							'name'       => 'show-type',
							'value_path' => array( 'show_product_type' ),
						),
					),
				),
			),
			'css_classes'                              => array(
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
			'icon_reset'                               => array(
				'title'       => array(
					'text'         => __( 'Icon', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array(
						'icon',
					),
				),
			),
			'icon_color'                               => array(
				'title'          => array(
					'text' => __( 'Icon color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array(
					'icon',
					'color',
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-wishlist__icon',
							'name'       => '--b-icon-color',
							'value_path' => array( 'icon', 'color' ),
						),
					),
				),
			),
			'icon_background'                          => array(
				'title'          => array(
					'text' => __( 'Background', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'icon', 'background' ),
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-wishlist__icon',
							'name'       => '--b-icon-background',
							'value_path' => array( 'icon', 'background' ),
						),
					),
				),
			),
			'icon_stroke_color'                        => array(
				'title'          => array(
					'text' => __( 'Stroke color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'icon', 'stroke', 'color' ),
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-wishlist__icon',
							'name'       => '--b-icon-stroke-color',
							'value_path' => array( 'icon', 'stroke', 'color' ),
						),
					),
				),
			),
			'icon_stroke_width'                        => array(
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
						'max'   => 10,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'icon', 'stroke', 'width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-wishlist__icon',
							'name'       => '--b-icon-stroke-width',
							'value_path' => array( 'icon', 'stroke', 'width' ),
						),
					),
				),
			),
			'icon_border_radius'                       => array(
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
				'value_path'     => array( 'icon', 'border_radius' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-wishlist__icon',
							'name'       => '--b-icon-border-radius',
							'value_path' => array( 'icon', 'border_radius' ),
						),
					),
				),
			),
			'icon_size'                                => array(
				'title'          => array(
					'text' => __( 'Icon size', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(
						array(
							'value' => 35,
						)
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'icon', 'size' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-wishlist__icon',
							'name'       => '--b-icon-size',
							'value_path' => array( 'icon', 'size' ),
						),
					),
				),
			),
			'badge_number_reset'                       => array(
				'title'       => array(
					'text'         => __( 'Count Badge', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'badge_number' ),
				),
			),
			'badge_number_color'                       => array(
				'title'          => array(
					'text' => __( 'Color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'badge_number', 'color' ),
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-wishlist',
							'name'       => '--b-badge-color',
							'value_path' => array( 'badge_number', 'color' ),
						),
					),
				),
			),
			'badge_number_background'                  => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'badge_number', 'background' ),
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-wishlist',
							'name'       => '--b-wishlist-badge-background-color',
							'value_path' => array( 'badge_number', 'background' ),
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
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-wishlist-drawer',
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
			// 			'desktop' => '#f2f2f2',
			// 			'tablet'  => null,
			// 			'mobile'  => null,
			// 		),
			// 		'hover'  => array(
			// 			'desktop' => '#f2f2f2',
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
			// 				'selector'   => '.brandy-wishlist-drawer',
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
			// 				'selector'   => '.brandy-wishlist-drawer',
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
			// 				'selector'   => '.brandy-wishlist-drawer',
			// 				'name'       => '--b-icon-close-stroke-width',
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
			// 			'value' => 18,
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
			// 				'selector'   => '.brandy-wishlist-drawer',
			// 				'name'       => '--b-icon-close-border-radius',
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
							'selector'   => '.brandy-wishlist-drawer',
							'name'       => '--b-icon-close-size',
							'value_path' => array( 'icon_close_panel_design', 'size' ),
						),
					),
				),
			),
			'text_reset'                               => array(
				'title'       => array(
					'text'         => __( 'Text', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'text' ),
				),
			),
			'text_typography'                          => array(
				'title'          => array(
					'text' => __( 'Typography', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Typography',
				'value_path'     => array( 'text', 'typography' ),
				'default_value'  => null,
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-wishlist__label',
							'value_path' => array( 'text', 'typography' ),
						),
					),
				),
			),
			'text_color'                               => array(
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'text', 'color' ),
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-text-color',
							'value_path' => array( 'text', 'color' ),
						),
					),
				),
			),
			'item_spacing'                             => array(
				'title'          => array(
					'text'         => __( 'Item Spacing', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'value_path'     => array( 'item_spacing' ),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 50,
						'value' => 10,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-wishlist',
							'name'       => 'gap',
							'value_path' => array( 'item_spacing' ),
						),
					),
				),
			),
			'margin'                                   => array(
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
							'name'       => '--b-margin',
							'value_path' => array( 'margin' ),
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
							'icon_title',
							'select_icon',
							'icon_style',
						),
					),
					array(
						'components' => array(
							'label_enable',
							'add_label',
							'label_position',
						),
					),
					array(
						'components' => array(
							'click_effect',
							'slide_position',
						),
					),
					array(
						'components' => array(
							'show_badge_number',
						),
					),
					array(
						'components' => array(
							'show_product_type',
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
							'icon_reset',
							'icon_color',
							'icon_background',
							'icon_stroke_color',
							'icon_stroke_width',
							'icon_border_radius',
							'icon_size',
						),
					),
					array(
						'visible_conditions' => array(
							array(
								'value_path' => array( 'show_badge' ),
								'value'      => true,
							),
						),
						'components'         => array(
							'badge_number_reset',
							'badge_number_color',
							'badge_number_background',
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
						'components' => array(
							'text_reset',
							'text_typography',
							'text_color',
						),
					),
					array(
						'components' => array(
							'item_spacing',
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
		$icons  = array();
		$styles = array( 'bold', 'outline' );
		foreach ( $styles as $style ) {
			$dir = new \DirectoryIterator( BRANDY_TEMPLATE_DIR . self::$path_to_icons . $style );
			foreach ( $dir as $fileinfo ) {
				if ( ! $fileinfo->isDot() ) {
					$file_name = $fileinfo->getFilename();
					$file_path = BRANDY_TEMPLATE_DIR . self::$path_to_icons . "$style/$file_name";
					$icon_name = basename( $file_name, '.php' );
					if ( $file_name && file_exists( $file_path ) ) {
						if ( empty( $icons ) ) {
							$icons = array();
						}
						ob_start();
						require $file_path;
						$icon_data = ob_get_contents();
						ob_end_clean();
						$icons[ $style ][ $icon_name ] = $icon_data;
					}
				}
			}
		}
		$localize_data['icons']['wishlist'] = $icons;
		return $localize_data;
	}

}
