<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Traits\SingletonTrait;

class Account extends AbstractBaseElement {

	use SingletonTrait;

	/**
	 * Element id
	 *
	 * @var string
	 */
	protected $element_id = 'account';

	/**
	 * Path to icon folder
	 *
	 * @var string
	 */
	public static $path_to_icons = BRANDY_TEMPLATE_DIR . '/template-parts/icons/account/';

	/**
	 * Constants
	 */
	public const LOGGED_IN_STATE  = 'logged_in';
	public const LOGGED_OUT_STATE = 'logged_out';

	/**
	 * Element icon
	 */
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
			d="M12.2727 5.15909C9.92602 5.15909 8.08823 5.62384 6.85603 6.85603C5.62383 8.08823 5.15909 9.92603 5.15909 12.2727V17.7273C5.15909 19.5061 5.42466 20.9866 6.08629 22.1365C6.76568 23.3173 7.81734 24.0717 9.21389 24.4671C9.32069 24.4973 9.43141 24.5031 9.53836 24.4858C10.3156 24.6812 11.2168 24.7727 12.2729 24.7727H17.7274C18.7834 24.7727 19.6846 24.6812 20.4618 24.4858C20.5687 24.5031 20.6794 24.4973 20.7861 24.4671C22.1827 24.0717 23.2343 23.3173 23.9137 22.1365C24.5753 20.9866 24.8409 19.5061 24.8409 17.7273V12.2727C24.8409 9.92603 24.3762 8.08823 23.144 6.85603C21.9118 5.62384 20.074 5.15909 17.7273 5.15909H12.2727ZM10.2688 23.2495C10.7326 21.6276 12.5769 20.2682 15 20.2682C17.4232 20.2682 19.2675 21.6276 19.7312 23.2496C19.4393 23.3042 19.1282 23.3441 18.7948 23.3703C18.4622 23.3965 18.1074 23.4091 17.7274 23.4091H12.2729C11.8929 23.4091 11.5381 23.3965 11.2054 23.3703C10.872 23.3441 10.5608 23.3041 10.2688 23.2495ZM6.65909 12.2727C6.65909 10.074 7.10343 8.72995 7.91669 7.91669C8.72995 7.10344 10.074 6.65909 12.2727 6.65909H17.7273C19.926 6.65909 21.27 7.10344 22.0833 7.91669C22.8966 8.72995 23.3409 10.074 23.3409 12.2727V17.7273C23.3409 19.3848 23.0883 20.5634 22.6136 21.3885C22.2761 21.975 21.8045 22.4209 21.1476 22.7367C20.4282 20.3728 17.8466 18.7682 15 18.7682C12.1534 18.7682 9.57182 20.3728 8.85241 22.7367C8.19545 22.4209 7.72389 21.975 7.38644 21.3885C6.9117 20.5634 6.65909 19.3848 6.65909 17.7273V12.2727ZM12.4955 13.7091C12.4955 12.3233 13.6142 11.2045 15 11.2045C16.3858 11.2045 17.5045 12.3233 17.5045 13.7091C17.5045 15.0976 16.3831 16.2227 15 16.2227C13.6169 16.2227 12.4955 15.0976 12.4955 13.7091ZM15 9.70455C12.7858 9.70455 10.9955 11.4949 10.9955 13.7091C10.9955 15.9206 12.7831 17.7227 15 17.7227C17.2169 17.7227 19.0045 15.9206 19.0045 13.7091C19.0045 11.4949 17.2142 9.70455 15 9.70455Z"
			fill="' . BRANDY_ICON_COLOR_NORMAL . '"
			/>
		</svg>';

	protected function __construct() {
		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );

		$this->title = __( 'Account', 'brandy' );

		parent::__construct();
	}

	/**
	 * Register settings components
	 */
	protected function register_components() {
		return array(
			'logged_in_title'          => array(
				'type' => 'AccountLoggedInTitle',
			),
			'logged_in_display_type'   => array(
				'title'          => array(
					'text' => __( 'Display type', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( self::LOGGED_IN_STATE, 'display_type' ),
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'label' => 'Avatar',
						'value' => 'avatar',
					),
					array(
						'label' => 'Icon',
						'value' => 'icon',
					),
					array(
						'label' => 'Text only',
						'value' => 'text',
					),
				),
				'default_value'  => 'icon',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'logged_in_icon_type'      => array(
				'title'              => array(
					'text' => __( 'Select icon', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( self::LOGGED_IN_STATE, 'icon_type' ),
				'type'               => 'AccountIconSelection',
				'default_value'      => 'icon_1',
				'visible_conditions' => array(
					array(
						'value_path' => array( self::LOGGED_IN_STATE, 'display_type' ),
						'value'      => 'icon',
					),
				),
				'render_options'     => array(
					'type' => 'force_refresh',
				),
			),
			'logged_in_icon_style'     => array(
				'title'              => array(
					'text' => __( 'Icon style', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( self::LOGGED_IN_STATE, 'icon_style' ),
				'type'               => 'ButtonGroup',
				'options'            => array(
					array(
						'label' => 'Bold',
						'value' => 'bold',
					),
					array(
						'label' => 'Outline',
						'value' => 'outline',
					),
				),
				'default_value'      => 'outline',
				'render_options'     => array(
					'type' => 'force_refresh',
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( self::LOGGED_IN_STATE, 'display_type' ),
						'value'      => 'icon',
					),
				),
			),
			'logged_in_label_enable'   => array(
				'title'              => array(
					'text'         => __( 'Enable label', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'description'        => __( 'Label will be shown as a tooltip on hover in desktop mode if this setting is OFF.', 'brandy' ),
				'value_path'         => array( self::LOGGED_IN_STATE, 'label_enable' ),
				'type'               => 'Switcher',
				'default_value'      => array(
					'desktop' => false,
					'tablet'  => true,
					'mobile'  => null,
				),
				'render_options'     => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-account__label',
							'name'           => 'class',
							'enabled_class'  => '',
							'disabled_class' => 'is-tooltip',
							'value_path'     => array( self::LOGGED_IN_STATE, 'label_enable', 'desktop' ),
						),
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-account__label',
							'name'           => 'class',
							'value_path'     => array( self::LOGGED_IN_STATE, 'label_enable', 'tablet' ),
							'enabled_class'  => '',
							'disabled_class' => 'hidden-md',
						),
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-account__label',
							'name'           => 'class',
							'value_path'     => array( self::LOGGED_IN_STATE, 'label_enable', 'mobile' ),
							'enabled_class'  => '',
							'disabled_class' => 'hidden-sm',
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( self::LOGGED_IN_STATE, 'display_type' ),
						'value'      => 'text',
						'operator'   => 'NOT',
					),
				),
			),
			'logged_in_label_type'     => array(
				'title'          => array(
					'text' => __( 'Type', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( self::LOGGED_IN_STATE, 'label_type' ),
				'type'           => 'ButtonGroup',
				'default_value'  => 'name',
				'options'        => array(
					array(
						'label' => __( 'Name', 'brandy' ),
						'value' => 'name',
					),
					array(
						'label' => __( 'Text', 'brandy' ),
						'value' => 'text',
					),
				),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'logged_in_label_text'     => array(
				'title'              => array(
					'text' => __( 'Custom text', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( self::LOGGED_IN_STATE, 'label_text' ),
				'type'               => 'TextInput',
				'default_value'      => 'Account',
				'render_options'     => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-account .brandy-account__label',
							'value_path' => array( self::LOGGED_IN_STATE, 'label_text' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( self::LOGGED_IN_STATE, 'label_type' ),
						'value'      => 'text',
					),
				),
			),
			'logged_in_label_position' => array(
				'title'              => array(
					'text' => __( 'Label position', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( self::LOGGED_IN_STATE, 'label_position' ),
				'type'               => 'Position',
				'default_value'      => array(
					'desktop' => 'right',
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-account',
							'value_path'        => array( self::LOGGED_IN_STATE, 'label_position' ),
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
					'relation' => 'AND',
					array(
						'value_path' => array( self::LOGGED_IN_STATE, 'label_enable' ),
						'value'      => true,
					),
					array(
						'value_path' => array( self::LOGGED_IN_STATE, 'display_type' ),
						'operator'   => 'NOT',
						'value'      => 'text',
					),
				),
			),
			'logged_out_title'         => array(
				'type' => 'AccountLoggedOutTitle',
			),
			'logged_out_display_type'  => array(
				'title'          => array(
					'text' => __( 'Display type', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'logged_out', 'display_type' ),
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'label' => 'Icon',
						'value' => 'icon',
					),
					array(
						'label' => 'Text only',
						'value' => 'text',
					),
				),
				'default_value'  => 'icon',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'logged_out_icon_type'     => array(
				'title'              => array(
					'text' => __( 'Select icon', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( 'logged_out', 'icon_type' ),
				'type'               => 'AccountIconSelection',
				'default_value'      => 'icon_1',
				'visible_conditions' => array(
					array(
						'value_path' => array( 'logged_out', 'display_type' ),
						'value'      => 'icon',
					),
				),
			),
			'logged_out_icon_style'    => array(
				'title'              => array(
					'text' => __( 'Icon style', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( 'logged_out', 'icon_style' ),
				'type'               => 'ButtonGroup',
				'options'            => array(
					array(
						'label' => 'Bold',
						'value' => 'bold',
					),
					array(
						'label' => 'Outline',
						'value' => 'outline',
					),
				),
				'default_value'      => 'outline',
				'visible_conditions' => array(
					array(
						'value_path' => array( 'logged_out', 'display_type' ),
						'value'      => 'icon',
					),
				),
			),
			'logged_out_label_enable'  => array(
				'title'              => array(
					'text'         => __( 'Enable label', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'description'        => __( 'Label will be shown as a tooltip on hover in desktop mode if this setting is OFF.', 'brandy' ),
				'value_path'         => array( self::LOGGED_OUT_STATE, 'label_enable' ),
				'type'               => 'Switcher',
				'default_value'      => array(
					'desktop' => false,
					'tablet'  => true,
					'mobile'  => null,
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( self::LOGGED_OUT_STATE, 'display_type' ),
						'value'      => 'text',
						'operator'   => 'NOT',
					),
				),
			),
			'logged_out_label_text'    => array(
				'title'         => array(
					'text' => __( 'Text', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'    => array( 'logged_out', 'label_text' ),
				'type'          => 'TextInput',
				'default_value' => 'Login',
			),
			'icon_reset'               => array(
				'title'       => array(
					'text'         => __( 'Icon', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'reset_paths' => array( array( 'icon' ) ),
				'type'        => 'Reset',
			),
			'icon_color'               => array(
				'title'          => array(
					'text' => __( 'Icon color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon', 'color' ),
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
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-account__icon',
							'name'       => '--b-icon-color',
							'value_path' => array( 'icon', 'color' ),
						),
					),
				),
			),
			'icon_background'          => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon', 'background' ),
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
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-account__icon',
							'name'       => '--b-icon-background-color',
							'value_path' => array( 'icon', 'background' ),
						),
					),
				),
			),
			'icon_border_color'        => array(
				'title'          => array(
					'text' => __( 'Border color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon', 'border', 'color' ),
				'type'           => 'ColorGroup',
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-account__icon',
							'name'       => '--b-icon-border-color',
							'value_path' => array( 'icon', 'border', 'color' ),
						),
					),
				),
			),
			'icon_border_width'        => array(
				'title'          => array(
					'text' => __( 'Border width', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon', 'border', 'width' ),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 30,
						'value' => 0,
					),
					'tablet'  => null,
					'mobile'  => null,

				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-account',
							'name'       => '--b-icon-stroke-width',
							'value_path' => array( 'icon', 'border', 'width' ),
						),
					),
				),
			),
			'icon_border_radius'       => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon', 'border_radius' ),
				'type'           => 'Dimension',
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 100,
						'value' => 100,
					),
					'tablet'  => null,
					'mobile'  => null,

				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-account',
							'name'       => '--b-icon-border-radius',
							'value_path' => array( 'icon', 'border_radius' ),
						),
					),
				),
			),
			'icon_size'                => array(
				'title'          => array(
					'text' => __( 'Size icon', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'icon', 'size' ),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(),
					'tablet'  => null,
					'mobile'  => null,

				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-account',
							'name'       => '--b-icon-size',
							'value_path' => array( 'icon', 'size' ),
						),
					),
				),
			),
			'label_reset'              => array(
				'type'        => 'Reset',
				'title'       => array(
					'text'         => __( 'Label', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'description' => __( 'Not affect to tooltip label', 'brandy' ),
				'reset_paths' => array(
					array( 'label' ),
				),
			),
			'label_typography'         => array(
				'title'          => array(
					'text' => __( 'Typography', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'label', 'typography' ),
				'type'           => 'Typography',
				'is_responsive'  => true,
				'default_value'  => null,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-account__label',
							'value_path' => array( 'label', 'typography' ),
						),
					),
				),
			),
			'label_color'              => array(
				'title'          => array(
					'text' => __( 'Color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'label', 'color' ),
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-color',
							'selector'   => '.brandy-account__label',
							'value_path' => array( 'label', 'color' ),
						),
					),
				),
			),
			'item_spacing'             => array(
				'title'          => array(
					'text'         => __( 'Item Spacing', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'description'    => __( 'Spacing between text and icon', 'brandy' ),
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
							'selector'   => '.brandy-account',
							'name'       => 'gap',
							'value_path' => array( 'item_spacing' ),
						),
					),
				),
			),
			'padding'                  => array(
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
							'selector'   => '.brandy-element-wrapper',
							'name'       => 'padding',
							'value_path' => array( 'padding' ),
						),
					),
				),
			),
			'margin'                   => array(
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
							'selector'   => '.brandy-element-wrapper',
							'name'       => 'margin',
							'value_path' => array( 'margin' ),
						),
					),
				),
			),
		);
	}

	/**
	 * Register settings layout
	 */
	protected function register_layout() {
		return array(
			'general' => array(
				'sections' => array(
					array(
						'components' => array( 'logged_in_title' ),
					),
					array(
						'components' => array(
							'logged_in_display_type',
							'logged_in_icon_type',
							'logged_in_icon_style',
						),
					),
					array(
						'components' => array(
							'logged_in_label_enable',
							'logged_in_label_type',
							'logged_in_label_text',
							'logged_in_label_position',
						),
					),
					array(
						'components' => array( 'logged_out_title' ),
					),
					array(
						'components' => array(
							'logged_out_display_type',
							'logged_out_icon_type',
							'logged_out_icon_style',
						),
					),
					array(
						'components' => array(
							'logged_out_label_enable',
							'logged_out_label_text',
						),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'visible_conditions' => array(
							'relation' => 'OR',
							array(
								'value_path' => array( self::LOGGED_IN_STATE, 'display_type' ),
								'operator'   => 'NOT',
								'value'      => 'text',
							),
							array(
								'value_path' => array( self::LOGGED_OUT_STATE, 'display_type' ),
								'operator'   => 'NOT',
								'value'      => 'text',
							),
						),
						'components'         => array(
							'icon_reset',
							'icon_color',
							'icon_background',
							'icon_border_color',
							'icon_border_width',
							'icon_border_radius',
							'icon_size',
						),
					),
					array(
						'components' => array(
							'label_reset',
							'label_typography',
							'label_color',
						),
					),
					array(
						'visible_conditions' => array(
							'groups' => array(
								array(
									'relation' => 'AND',
									array(
										'value_path' => array( self::LOGGED_IN_STATE, 'display_type' ),
										'operator'   => 'NOT',
										'value'      => 'text',
									),
									array(
										'value_path' => array( self::LOGGED_IN_STATE, 'label_enable' ),
										'operator'   => 'NOT',
										'value'      => true,
									),
								),
								array(
									'relation' => 'AND',
									array(
										'value_path' => array( self::LOGGED_OUT_STATE, 'display_type' ),
										'operator'   => 'NOT',
										'value'      => 'text',
									),
									array(
										'value_path' => array( self::LOGGED_OUT_STATE, 'label_enable' ),
										'operator'   => 'NOT',
										'value'      => true,
									),
								),
							),
						),
						'components'         => array(
							'item_spacing',
						),
					),
					array(
						'components' => array(
							'padding',
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
	}

	/**
	 * Add element localize data to the general
	 *
	 * @param array $localize_data General data
	 *
	 * @return array Data after adding
	 */
	public function add_localize_data( $localize_data ) {
		$icons       = array();
		$icon_styles = array( 'bold', 'outline' );
		foreach ( $icon_styles as $style ) {
			$dir        = new \DirectoryIterator( self::$path_to_icons . $style );
			$icon_files = array();
			foreach ( $dir as $fileinfo ) {
				if ( ! $fileinfo->isDot() ) {
					$icon_files[] = $fileinfo->getFilename();
				}
			}
			usort(
				$icon_files,
				function( $a, $b ) {
					return strcmp( $a, $b );
				}
			);
			$icons[ $style ] = array();
			foreach ( $icon_files as $file_name ) {
				$icon_path = self::$path_to_icons . "$style/$file_name";
				ob_start();
				require $icon_path;
				$icon_data = ob_get_contents();
				ob_end_clean();

				$icon_name                     = basename( $file_name, '.php' );
				$icons[ $style ][ $icon_name ] = $icon_data;
			}

			$localize_data['icons']['account'] = $icons;
		}
		return $localize_data;
	}

	/**
	 * Get account icon based on icon type and style
	 *
	 * @param string $icon_type
	 * @param string $icon style
	 *
	 * @return string
	 */
	public static function get_icon( $icon_type, $icon_style ) {
		$icon_path = self::$path_to_icons . "$icon_style/$icon_type.php";
		if ( file_exists( $icon_path ) ) {
			ob_start();
			require $icon_path;
			$icon_data = ob_get_contents();
			ob_end_clean();
			return $icon_data;
		}
		return '';
	}

	/**
	 * Get account icon based on state
	 *
	 * @param array $settings Account settings
	 *
	 * @return string
	 */
	public static function get_account_icon( $settings ) {
		$icon         = '';
		$state        = self::get_state();
		$display_type = isset( $settings[ $state ]['display_type'] ) ? $settings[ $state ]['display_type'] : 'avatar';
		if ( is_user_logged_in() ) {
			$current_user_id = get_current_user_id();
			if ( 'avatar' === $display_type ) {
				$icon = get_avatar( $current_user_id );
			}
		}
		if ( 'icon' === $display_type ) {
			$icon_type  = $settings[ $state ]['icon_type'] ?? 'icon_1';
			$icon_style = $settings[ $state ]['icon_style'] ?? 'outline';
			$icon       = self::get_icon( $icon_type, $icon_style );
		}
		return $icon;
	}

	/**
	 * Get account link based on state
	 *
	 * @return string
	 */
	public static function get_account_link( $settings ) {
		$state = self::get_state();

		if ( $state === self::LOGGED_IN_STATE ) {
			return is_wc_installed() ? wc_get_account_endpoint_url( 'dashboard' ) : get_edit_user_link( get_current_user_id() );
		}

		return brandy_get_login_url();
	}

	/**
	 * Get account label based on state
	 *
	 * @return string
	 */
	public static function get_account_label( $settings ) {
		$state      = self::get_state();
		$label_type = $settings[ $state ]['label_type'] ?? 'name';
		$label      = $settings[ $state ]['label_text'] ?? '';
		if ( is_user_logged_in() && 'name' === $label_type ) {
			$label = self::get_account_display_name();
		}
		return $label;
	}

	/**
	 * Get user display name
	 *
	 * @return string
	 */
	private static function get_account_display_name() {
		$user_info = wp_get_current_user();
		$name_list = array(
			! empty( $user_info->first_name ) ? $user_info->first_name : '',
			! empty( $user_info->last_name ) ? $user_info->last_name : '',
		);
		$name      = implode( ' ', $name_list );
		if ( empty( trim( $name ) ) ) {
			$name = $user_info->display_name;
		}
		return $name;
	}

	/**
	 * Returns current logged state
	 *
	 * @return string
	 */
	public static function get_state() {
		return is_user_logged_in() ? self::LOGGED_IN_STATE : self::LOGGED_OUT_STATE;
	}

}
