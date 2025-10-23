<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;

class BaseButton extends AbstractBaseElement {

	/**
	 * Components display in settings page
	 *
	 * @var array
	 */
	protected $components = array();

	/**
	 * Element id
	 *
	 * @var string
	 */
	protected $element_id = 'button';

	protected $title = 'Button';

	/**
	 * Builders contain this element
	 *
	 * @var array
	 */
	protected $builders = array( 'header', 'footer' );

	/**
	 * Path to folder that contains necessary icons
	 *
	 * @var string
	 */
	public static $path_to_icons = BRANDY_TEMPLATE_DIR . '/template-parts/icons/button/';

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
			  d="M6.5 6.25C5.39842 6.25 4.25 7.08149 4.25 8.28571V17.7143C4.25 18.9185 5.39842 19.75 6.5 19.75H11C11.4142 19.75 11.75 19.4142 11.75 19C11.75 18.5858 11.4142 18.25 11 18.25H6.5C6.00158 18.25 5.75 17.8815 5.75 17.7143V8.28571C5.75 8.11851 6.00158 7.75 6.5 7.75H23.5C23.9984 7.75 24.25 8.11851 24.25 8.28571V17.7143C24.25 18.1285 24.5858 18.4643 25 18.4643C25.4142 18.4643 25.75 18.1285 25.75 17.7143V8.28571C25.75 7.08149 24.6016 6.25 23.5 6.25H6.5ZM23.18 18.8843C23.332 19.5482 23.236 20.2242 22.896 20.8921C22.882 20.9225 22.876 20.9771 22.882 21.0014C23.03 21.469 22.994 21.9527 22.78 22.3636C22.5521 22.8069 22.1341 23.1388 21.6041 23.2987C20.6322 23.5942 19.6542 23.8816 18.6763 24.1609C18.4643 24.2217 18.2563 24.25 18.0523 24.25C17.3464 24.25 16.7064 23.8978 16.3325 23.2663C16.3265 23.2562 16.3025 23.24 16.2905 23.238C14.9625 22.8919 14.0746 22.1025 13.6426 20.8861L13.5766 20.7019L13.5711 20.6867C13.4648 20.3937 13.3535 20.0873 13.2887 19.7769C13.1127 18.9369 13.5486 18.0828 14.3726 17.6496C14.2975 17.4312 14.2227 17.2141 14.1482 16.998C13.9116 16.3108 13.6784 15.6336 13.4486 14.9577C13.3266 14.5994 13.3506 14.2351 13.5166 13.9315C13.6906 13.6117 14.0026 13.383 14.3966 13.2878C15.0545 13.13 15.7605 13.4801 15.9785 14.0772C16.1272 14.4741 16.2621 14.8746 16.3976 15.2769C16.4079 15.3074 16.4181 15.338 16.4285 15.3685L16.5504 15.7308C17.0304 15.4212 17.5964 15.4131 18.1123 15.7147C18.3343 15.4799 18.6143 15.3382 18.9463 15.2937C19.3463 15.239 19.6542 15.3544 19.8642 15.4799C19.9082 15.4515 19.9482 15.4232 19.9882 15.3949C20.1242 15.2997 20.2642 15.2026 20.4262 15.1378C20.7822 15.0002 21.1641 15.0103 21.5041 15.1661C21.8281 15.3159 22.0741 15.579 22.1941 15.911C22.4161 16.5263 22.6261 17.1456 22.832 17.765L22.898 17.9593C22.903 17.9738 22.9079 17.9883 22.9129 18.0028C23.0104 18.289 23.1115 18.5857 23.18 18.8843ZM21.9781 21.888C22.0741 21.6673 22.0661 21.4386 21.9541 21.1694C21.8701 20.965 21.8881 20.7788 22.0041 20.5744C22.3101 20.0663 22.3941 19.5381 22.2521 19.0017C22.1701 18.688 22.0621 18.3763 21.9561 18.0727L21.8421 17.7407C21.6681 17.2205 21.4881 16.7024 21.3041 16.1863C21.2301 15.9818 21.0162 15.8806 20.7802 15.9434C20.5702 16.0021 20.4502 16.1964 20.5042 16.3988C20.5142 16.4352 20.5262 16.4716 20.5402 16.5081C20.5562 16.5506 20.5722 16.5951 20.5842 16.6396C20.6262 16.7752 20.6182 16.9088 20.5582 17.0181C20.5002 17.1214 20.4042 17.1962 20.2762 17.2307C20.0142 17.2995 19.7982 17.1801 19.6982 16.9068C19.6742 16.84 19.6502 16.7712 19.6262 16.7024C19.5942 16.6073 19.5603 16.5101 19.5223 16.417C19.4423 16.2146 19.2143 16.1134 18.9923 16.1782C18.8823 16.2105 18.7943 16.2794 18.7463 16.3704C18.7023 16.4494 18.6943 16.5405 18.7223 16.6295L18.7623 16.751C18.7693 16.7732 18.7768 16.7955 18.7843 16.8177C18.7918 16.84 18.7993 16.8623 18.8063 16.8845C18.8443 17.0141 18.8343 17.1436 18.7743 17.2509C18.7183 17.3561 18.6183 17.431 18.4983 17.4634C18.2463 17.5302 18.0143 17.4067 17.9224 17.1578L17.7504 16.672C17.6664 16.4352 17.4464 16.3158 17.2084 16.3866C17.0924 16.421 17.0064 16.4858 16.9604 16.5769C16.9124 16.6659 16.9084 16.7752 16.9444 16.8886L16.9644 16.9453C16.9676 16.9541 16.9707 16.9629 16.9739 16.9718C16.997 17.0362 17.0206 17.1018 17.0364 17.1659C17.1004 17.3946 16.9664 17.6294 16.7324 17.7002C16.5064 17.7711 16.2665 17.6678 16.1645 17.4533C16.1494 17.4211 16.1371 17.3888 16.1253 17.3578C16.123 17.3518 16.1207 17.3458 16.1185 17.34L15.8645 16.6032C15.6205 15.8907 15.3765 15.1783 15.1305 14.4658C15.1045 14.3909 15.0745 14.3302 15.0425 14.2857C14.9305 14.1379 14.7066 14.0894 14.5226 14.1723C14.3346 14.2553 14.2466 14.4395 14.3106 14.6197C14.5006 15.1803 14.6926 15.741 14.8846 16.3016C14.9498 16.4928 15.015 16.6835 15.0801 16.8739C15.2068 17.2441 15.3331 17.6134 15.4585 17.9836L15.6105 18.4269C15.7245 18.7568 15.8365 19.0867 15.9465 19.4166C15.9845 19.5279 15.9765 19.6453 15.9245 19.7465C15.8705 19.8538 15.7725 19.9327 15.6485 19.9692C15.4105 20.0441 15.1745 19.9368 15.0745 19.7101C15.0525 19.6575 15.0345 19.6069 15.0185 19.5563C14.9085 19.2142 14.7926 18.864 14.6706 18.5098C14.3106 18.7628 14.1086 19.2344 14.2006 19.6251C14.2626 19.8761 14.3526 20.1331 14.4406 20.3801L14.5146 20.5865C14.8666 21.5904 15.5765 22.1875 16.6844 22.4102C16.8964 22.4547 17.0324 22.562 17.1124 22.7522C17.3064 23.2339 17.8324 23.4728 18.3563 23.321C19.3623 23.0336 20.3642 22.736 21.3641 22.4385C21.6441 22.3555 21.8501 22.1713 21.9781 21.888Z"
			  fill="' . BRANDY_ICON_COLOR_NORMAL . '"
			/>
		  </svg>';

	/**
	 * Constructor
	 */
	protected function __construct() {
		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );
		parent::__construct();
	}

	/**
	 * Register components display in settings page
	 */
	protected function register_components() {
		$components = array(
			'button_text'                    => array(
				'value_path'     => array( 'text' ),
				'default_value'  => 'Button',
				'title'          => array(
					'text' => __( 'Button text', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'TextInput',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-button-text-wrap',
							'value_path' => array( 'text' ),
						),
					),
				),
			),
			'button_link'                    => array(
				'value_path'     => array( 'link' ),
				'default_value'  => '#',
				'title'          => array(
					'text' => __( 'Button link', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'TextInput',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => 'a.brandy-button',
							'name'       => 'href',
							'value_path' => array( 'link' ),
						),
					),
				),
			),
			'icon_enabled'                   => array(
				'value_path'     => array( 'icon_enabled' ),
				'title'          => array(
					'text' => __( 'Button icon', 'brandy' ),
					'type' => 'bold',
				),
				'default_value'  => true,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'button_icon'                    => array(
				'value_path'         => array( 'icon' ),
				'default_value'      => 'icon_3',
				'type'               => 'ButtonIconSelection',
				'render_options'     => array(
					'type' => 'force_refresh',
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'icon_enabled' ),
						'value'      => true,
					),
				),
			),
			'button_icon_position'           => array(
				'value_path'     => array( 'icon_position' ),
				'title'          => array(
					'text' => __( 'Icon position', 'brandy' ),
				),
				'default_value'  => '-1',
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'label' => __( 'Left', 'brandy' ),
						'value' => '-1',
					),
					array(
						'label' => __( 'Right', 'brandy' ),
						'value' => '1',
					),
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'default',
							'selector'   => '.brandy-theme-icon',
							'name'       => 'order',
							'value_path' => array( 'icon_position' ),
						),
					),
				),
			),
			'button_type'                    => array(
				'title'          => array(
					'text' => __( 'Button type', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'type' ),
				'type'           => 'ButtonType',
				'options'        => array(
					array(
						'label' => __( 'Fill', 'brandy' ),
						'value' => 'fill',
					),
					array(
						'label' => __( 'Outline', 'brandy' ),
						'value' => 'outline',
					),
				),
				'default_value'  => 'fill',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-element-wrapper',
							'name'       => 'data-type',
							'value_path' => array( 'type' ),
						),
					),
				),
			),
			'button_size'                    => array(
				'title'          => array(
					'text' => __( 'Button size', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'size' ),
				'type'           => 'ButtonSize',
				'options'        => array(
					array(
						'label' => __( 'Small', 'brandy' ),
						'value' => 'small',
					),
					array(
						'label' => __( 'Medium', 'brandy' ),
						'value' => 'medium',
					),
					array(
						'label' => __( 'large', 'brandy' ),
						'value' => 'large',
					),
				),
				'default_value'  => 'medium',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-button',
							'value_path'        => array( 'size' ),
							'mapping_variables' => array(
								array(
									'condition' => array(
										'operator' => 'equal',
										'value'    => 'small',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'min-height' => '30px',
										),
									),
								),
								array(
									'condition' => array(
										'operator' => 'equal',
										'value'    => 'medium',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'min-height' => '38px',
										),
									),
								),
								array(
									'condition' => array(
										'operator' => 'equal',
										'value'    => 'large',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'min-height' => '48px',
										),
									),
								),
							),
						),
					),
				),
			),
			'link_new_tab'                   => array(
				'value_path'     => array( 'link_new_tab' ),
				'title'          => array(
					'text' => __( 'Open link in new tab', 'brandy' ),
				),
				'default_value'  => true,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'type'           => 'switcher',
							'selector'       => 'a.brandy-button',
							'name'           => 'target',
							'value_path'     => array( 'link_new_tab' ),
							'enabled_value'  => '_blank',
							'disabled_value' => '_self',
						),
					),
				),
			),
			// 'css_class'                      => array(
			// 	'value_path'     => array( 'css_class' ),
			// 	'default_value'  => '',
			// 	'title'          => array(
			// 		'text' => __( 'CSS classes', 'brandy' ),
			// 		'type' => 'bold',
			// 	),
			// 	'type'           => 'TextInput',
			// 	'render_options' => array(
			// 		'type' => 'data_attribute',
			// 		'data' => array(
			// 			array(
			// 				'selector'      => '.brandy-element-wrapper',
			// 				'name'          => 'class',
			// 				'default_class' => 'brandy-element-wrapper',
			// 				'value_path'    => array(
			// 					'css_class',
			// 				),
			// 			),
			// 		),
			// 	),
			// ),
			'inherit_theme_setting'          => array(
				'title'          => array(
					'text' => __( 'Inherit from theme', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'value_path'     => array( 'inherit_theme' ),
				'default_value'  => true,
				'render_options' => array(
					'type' => 'force_refresh',
					// 'data' => array(
					// 	array(
					// 		'selector'       => '.brandy-element-wrapper',
					// 		'name'           => 'class',
					// 		'type'           => 'switcher',
					// 		'value_path'     => array( 'inherit_theme' ),
					// 		'enabled_class'  => '',
					// 		'disabled_class' => 'brandy-custom-button',
					// 	),
					// 	array(
					// 		'selector'       => '.brandy-element-wrapper',
					// 		'name'           => 'class',
					// 		'type'           => 'switcher',
					// 		'value_path'     => array( 'inherit_theme' ),
					// 		'disabled_class' => '',
					// 		'enabled_class'  => 'wp-block-button',
					// 	),
					// 	array(
					// 		'selector'       => '.brandy-element-wrapper[data-type="fill"] .brandy-button',
					// 		'name'           => 'class',
					// 		'type'           => 'switcher',
					// 		'value_path'     => array( 'inherit_theme' ),
					// 		'disabled_class' => '',
					// 		'enabled_class'  => 'wp-element-button',
					// 	),
					// 	array(
					// 		'selector'       => '.brandy-element-wrapper[data-type="outline"]',
					// 		'name'           => 'class',
					// 		'type'           => 'switcher',
					// 		'value_path'     => array( 'inherit_theme' ),
					// 		'disabled_class' => '',
					// 		'enabled_class'  => 'is-style-outline is-style-outline--1 wp-block-button',
					// 	),
					// 	array(
					// 		'selector'       => '.brandy-element-wrapper[data-type="outline"] .brandy-button',
					// 		'name'           => 'class',
					// 		'type'           => 'switcher',
					// 		'value_path'     => array( 'inherit_theme' ),
					// 		'disabled_class' => '',
					// 		'enabled_class'  => 'wp-element-button wp-block-button__link',
					// 	),
					// ),
				),
			),
			'button_design_reset'            => array(
				'title'       => array(
					'text'         => __( 'Button', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'button_design' ),
				),
			),
			'button_design_background_color' => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'button_design', 'background_color' ),
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
							'name'       => '--b-bg-color',
							'selector'   => '.brandy-custom-button .brandy-button',
							'value_path' => array( 'button_design', 'background_color' ),
						),
					),
				),
			),
			'button_border_color'            => array(
				'title'              => array(
					'text' => __( 'Border color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( 'button_design', 'border', 'color' ),
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
				),
				'type'               => 'ColorGroup',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-border-color',
							'selector'   => '.brandy-custom-button[data-type="outline"] .brandy-button',
							'value_path' => array( 'button_design', 'border', 'color' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'type' ),
						'value'      => 'outline',
					),
				),
			),
			'button_border_width'            => array(
				'title'              => array(
					'text' => __( 'Border width', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( 'button_design', 'border', 'width' ),
				'default_value'      => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 20,
						'value' => 1,
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
							'name'       => 'border-width',
							'selector'   => '.brandy-custom-button .brandy-button',
							'value_path' => array( 'button_design', 'border', 'width' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'type' ),
						'value'      => 'outline',
					),
				),
			),
			'button_design_border_radius'    => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'button_design', 'border_radius' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 50,
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
							'name'       => 'border-radius',
							'selector'   => '.brandy-custom-button .brandy-button',
							'value_path' => array( 'button_design', 'border_radius' ),
						),
					),
				),
			),
			'button_design_box_shadow'       => array(
				'title'          => array(
					'text' => __( 'Box shadow', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'BoxShadow',
				'default_value'  => array(
					'enabled'      => true,
					'type'         => 'default',
					'custom_value' => array(
						'color'  => '#c4c3c3',
						'x'      => 3,
						'y'      => 3,
						'blur'   => 6,
						'spread' => 1,
					),
				),
				'value_path'     => array( 'button_design_box_shadow' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'box_shadow',
							'name'       => 'box-shadow',
							'selector'   => '.brandy-button',
							'value_path' => array( 'button_design_box_shadow' ),
						),
					),
				),
			),
			'button_design_text_reset'       => array(
				'title'       => array(
					'text'         => __( 'Text', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'button_design_text' ),
				),
			),
			'button_design_text_color'       => array(
				'title'              => array(
					'text' => __( 'Text Color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( 'button_design_text', 'color' ),
				'default_value'      => array(
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
				'type'               => 'ColorGroup',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-text-color',
							'selector'   => '.brandy-custom-button .brandy-button',
							'value_path' => array( 'button_design_text', 'color' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'inherit_theme' ),
						'value'      => false,
					),
				),
			),
			'button_design_text_typography'  => array(
				'value_path'     => array( 'button_design_text', 'typography' ),
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
							'selector'   => '.brandy-button',
							'value_path' => array( 'button_design_text', 'typography' ),
						),
					),
				),
			),
			//item spacing
			'button_design_item_spacing'     => array(
				'value_path'     => array( 'button_design_item_spacing' ),
				'title'          => array(
					'text' => 'Icon and text spacing',
					'type' => 'bold',
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 7,
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
							'name'       => 'gap',
							'selector'   => '.brandy-button',
							'value_path' => array( 'button_design_item_spacing' ),
						),
					),
				),
			),
			'button_design_padding'          => array(
				'value_path'     => array( 'button_design_padding' ),
				'title'          => array(
					'text' => 'Padding',
					'type' => 'bold',
				),
				'default_value'  => array(
					'unit'           => 'px',
					'top'            => 12,
					'right'          => 16,
					'bottom'         => 12,
					'left'           => 16,
					'is_constraints' => false,
				),
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'force_refresh',
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => 'padding',
							'selector'   => '.brandy-button',
							'value_path' => array( 'button_design_padding' ),
						),
					),
				),
			),
			//margin
			'button_design_margin'           => array(
				'value_path'     => array( 'button_design_margin' ),
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
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => 'margin',
							'selector'   => '.brandy-button',
							'value_path' => array( 'button_design_margin' ),
						),
					),
				),
			),
		);
		return $components;
	}

	/**
	 * Register layout for this element
	 *
	 * @param array $layouts Registered layouts
	 *
	 * @return array Layouts after registering
	 */
	public function add_layout( $layouts = array() ) {
		$layout = array(
			'general' => array(
				'sections' => array(
					array(
						'components' => array(
							'button_text',
						),
					),
					array(
						'components' => array(
							'button_link',
							'link_new_tab',
						),
					),
					array(
						'components' => array(
							'icon_enabled',
							'button_icon',
							'button_icon_position',
						),
					),
					array(
						'components' => array(
							'button_type',
						),
					),
					array(
						'components' => array(
							'button_size',
						),
					),
					// array(
					// 	'components' => array(
					// 		'css_class',
					// 	),
					// ),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array(
							'inherit_theme_setting',
						),
					),
					array(
						'components'         => array(
							'button_design_reset',
							'button_design_background_color',
							'button_border_color',
							'button_border_width',
							'button_design_border_radius',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'inherit_theme' ),
								'value'      => false,
							),
						),
					),
					array(
						'components' => array(
							'button_design_text_reset',
							'button_design_text_color',
							'button_design_text_typography',
						),
					),
					array(
						'components'         => array(
							'button_design_item_spacing',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'icon_enabled' ),
								'value'      => true,
							),
						),
					),
					array(
						'components'         => array(
							'button_design_box_shadow',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'inherit_theme' ),
								'value'      => false,
							),
						),
					),
					array(
						'components' => array(
							'button_design_padding',
						),
					),
					array(
						'components' => array(
							'button_design_margin',
						),
					),

				),
			),
		);
		$mapped_layout                = $this->map_layout( $layout );
		$layouts[ $this->element_id ] = $mapped_layout;
		return $layouts;
	}

	/**
	 * Add localize data for this element
	 *
	 * @param array $localize_data General localize data
	 *
	 * @return array Data after adding
	 */
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
			$file_path = self::$path_to_icons . '/' . $file_name;
			$icon_name = basename( $file_name, '.php' );
			ob_start();
			require $file_path;
			$icon_data = ob_get_contents();
			ob_end_clean();
			$icons[ $icon_name ] = $icon_data;
		}
		$localize_data['icons']['button'] = $icons;
		return $localize_data;
	}

	/**
	 * Return icon by icon type
	 *
	 * @param string $icon_type Given icon type
	 *
	 * @return string Icon string
	 */
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

	public function template_path() {
		return 'template-parts/builder/elements/button';
	}
}
