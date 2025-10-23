<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\TypographyService;

class BaseLogo extends AbstractBaseElement {

	protected $element_id = 'logo';

	protected $builders = array( 'header' );

	protected $title = 'Logo';

	protected $icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M6.5 16.0003C6.5 11.3057 10.3057 7.5 15.0003 7.5C19.6949 7.5 23.5006 11.3057 23.5006 16.0003C23.5006 16.2767 23.4874 16.5499 23.4616 16.8195L19.0595 14.4184C18.8072 14.2808 18.4984 14.2995 18.2645 14.4665L15.352 16.5469L12.026 15.2996C11.8119 15.2193 11.5729 15.2411 11.3768 15.3587L6.76752 18.1243C6.59288 17.4454 6.5 16.7337 6.5 16.0003ZM7.25937 19.5172C8.59706 22.4568 11.56 24.5006 15.0003 24.5006C18.8735 24.5006 22.1416 21.9102 23.1667 18.3673L18.7539 15.9603L15.8987 17.9997C15.6955 18.1449 15.4333 18.1793 15.1994 18.0916L11.8382 16.8312L7.52339 19.4201C7.4397 19.4703 7.35016 19.5023 7.25937 19.5172ZM15.0003 6C9.47728 6 5 10.4773 5 16.0003C5 21.5233 9.47728 26.0006 15.0003 26.0006C20.5233 26.0006 25.0006 21.5233 25.0006 16.0003C25.0006 10.4773 20.5233 6 15.0003 6Z" fill="' . BRANDY_ICON_COLOR_NORMAL . '"/>
			</svg>
			';

	public const NEW_VALUES = array(
		'logo_enabled_devices' => array( 'desktop', 'mobile' ),
	);

	public function template_path() {
		return 'template-parts/builder/elements/logo';
	}

	protected function register_components() {
		return array(
			'logo_reset'              => array(
				'title'       => array(
					'text' => __( 'Logo', 'brandy' ),
					'type' => 'bold',
				),
				'description' => __( 'Leave empty to use the site icon', 'brandy' ),
				'type'        => 'ResetLogo',
				'reset_paths' => array(
					array( 'logo', 'url' ),
				),
			),
			'logo_url'                => array(
				'value_path'     => array( 'logo', 'url' ),
				'default_value'  => '',
				'type'           => 'Image',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'       => '.brandy-logo[logo-type="primary"] img.logo-desktop',
							'name'           => 'src',
							'value_path'     => array( 'logo', 'url' ),
							'fallback_value' => get_site_icon_url(),
						),
						array(
							'selector'   => '.brandy-logo[logo-type="primary"] img.logo-mobile[data-using-desktop-source="true"]',
							'name'       => 'src',
							'value_path' => array( 'logo', 'url' ),
						),
					),
				),
			),
			'logo_height'             => array(
				'value_path'     => array( 'logo', 'height' ),
				'title'          => array(
					'text' => 'Height',
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'unit'  => 'px',
					'value' => 30,
					'min'   => 24,
					'max'   => 80,
				),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => 'height',
							'selector'   => '.brandy-logo__img.logo-desktop',
							'value_path' => array( 'logo', 'height' ),
						)
					),
				),
			),
			'logo_mobile_reset'       => array(
				'title'       => array(
					'text' => __( 'Logo on tablet/mobile (Optional)', 'brandy' ),
					'type' => 'bold',
				),
				'description' => __( 'Choose a different logo from the desktop logo', 'brandy' ),
				'type'        => 'ResetLogo',
				'reset_paths' => array(
					array( 'logo_mobile', 'url' ),
				),
			),
			'logo_mobile_url'         => array(
				'value_path'     => array( 'logo_mobile', 'url' ),
				'default_value'  => '',
				'type'           => 'Image',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'type'           => 'switcher',
							'name'           => 'data-using-desktop-source',
							'selector'       => '.brandy-logo[logo-type="primary"] img.logo-mobile',
							'value_path'     => array( 'logo_mobile', 'url' ),
							'enabled_value'  => 'false',
							'disabled_value' => 'true',
						),
						array(
							'selector'   => '.brandy-logo[logo-type="primary"] img.logo-mobile[data-using-desktop-source="false"]',
							'name'       => 'src',
							'value_path' => array( 'logo_mobile', 'url' ),
						),
					),
				),
			),
			'logo_mobile_height'      => array(
				'value_path'     => array( 'logo_mobile', 'height' ),
				'title'          => array(
					'text' => 'Height',
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'unit'  => 'px',
					'value' => 30,
					'min'   => 24,
					'max'   => 80,
				),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => 'height',
							'selector'   => '.brandy-logo__img.logo-mobile',
							'value_path' => array( 'logo_mobile', 'height' ),
						),
						array(
							'type'       => 'dimension',
							'name'       => 'min-width',
							'selector'   => '.brandy-logo__img.logo-mobile',
							'value_path' => array( 'logo_mobile', 'height' ),
						),
					),
				),
			),
			'sticky_logo_enabled'     => array(
				'value_path'     => array( 'sticky_logo', 'enabled' ),
				'description'    => __( 'Choose a different scroll logo from the main logo', 'brandy' ),
				'title'          => array(
					'text' => __( 'Sticky Logo (Optional)', 'brandy' ),
					'type' => 'bold',
				),
				'default_value'  => true,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'sticky_logo_url'         => array(
				'value_path'         => array( 'sticky_logo', 'url' ),
				'default_value'      => '',
				'type'               => 'Image',
				'render_options'     => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-logo[logo-type="sticky"] img',
							'name'       => 'src',
							'value_path' => array( 'sticky_logo', 'url' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'sticky_logo', 'enabled' ),
						'value'      => true,
					),
				),
			),
			'sticky_logo_height'      => array(
				'value_path'         => array( 'sticky_logo', 'height' ),
				'title'              => array(
					'text' => 'Height',
					'type' => 'normal',
				),
				'units'              => array( 'px' ),
				'default_value'      => array(
					'unit'  => 'px',
					'value' => 30,
					'min'   => 24,
					'max'   => 80,
				),
				'type'               => 'Dimension',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-logo[logo-type="sticky"]',
							'name'       => 'height',
							'value_path' => array( 'sticky_logo', 'height' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'sticky_logo', 'enabled' ),
						'value'      => true,
					),
				),
			),
			'logo_enabled'            => array(
				'title'          => array(
					'text' => __( 'Enable Logo On', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'EnabledDevices',
				'value_path'     => array( 'logo_enabled_devices' ),
				'default_value'  => self::NEW_VALUES['logo_enabled_devices'],
				'render_options' => array(
					'type'     => 'custom',
					'selector' => '.brandy-logo-images',
				),
			),
			'title_text'              => array(
				'title'          => array(
					'text' => __( 'Site Title', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'title', 'text' ),
				'default_value'  => get_bloginfo( 'name' ),
				'type'           => 'SiteTitle',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-logo__title',
							'value_path' => array( 'title', 'text' ),
						),
					),
				),
			),
			'title_enabled'           => array(
				'title'          => array(
					'text' => __( 'Visible on', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'EnabledDevices',
				'value_path'     => array( 'title', 'enabled_devices' ),
				'default_value'  => array(),
				'render_options' => array(
					'type'     => 'custom',
					'selector' => '.brandy-logo__title',
				),
			),
			'tagline_text'            => array(
				'title'          => array(
					'text' => __( 'Tagline', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'tagline', 'text' ),
				'default_value'  => get_bloginfo( 'description' ),
				'type'           => 'SiteTagline',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-logo__tagline',
							'value_path' => array( 'tagline', 'text' ),
						),
					),
				),
			),
			'tagline_enabled'         => array(
				'title'          => array(
					'text' => __( 'Enable on', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'EnabledDevices',
				'value_path'     => array( 'tagline', 'enabled_devices' ),
				'default_value'  => array(),
				'render_options' => array(
					'type'     => 'custom',
					'selector' => '.brandy-logo__tagline',
				),
			),
			'content_layout'          => array(
				'title' => array(
					'text' => __( 'Content layout', 'brandy' ),
					'type' => 'bold',
				),
				'type'  => 'Reset',
			),
			'content_position'        => array(
				'value_path'         => array( 'content_position' ),
				'title'              => array(
					'text' => __( 'Content position (in relation to the logo)', 'brandy' ),
				),
				'default_value'      => 'right',
				'type'               => 'Position',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-logo',
							'value_path'        => array( 'content_position' ),
							'mapping_variables' => array(
								array(

									'condition' => array(
										'operator' => 'equal',
										'value'    => 'right',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'flex-direction' => 'row',
										),
									),
								),
								array(

									'condition' => array(
										'operator' => 'equal',
										'value'    => 'left',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'flex-direction' => 'row-reverse',
										),
									),
								),
								array(

									'condition' => array(
										'operator' => 'equal',
										'value'    => 'bottom',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'flex-direction' => 'column',
										),
									),
								),
							),
						),
					),
				),
				'visible_conditions' => array(
					'groups' => array(
						array(
							array(
								'value_path' => array( 'title', 'enabled_devices' ),
								'value'      => array( 'desktop' ),
								'operator'   => 'CONTAIN',
							),
							array(
								'value_path'          => array( 'logo_enabled_devices' ),
								'value'               => array( 'desktop' ),
								'operator'            => 'CONTAIN',
								'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
							),
							array(
								'devices' => array( 'desktop' ),
							),
						),
						array(
							array(
								'value_path' => array( 'title', 'enabled_devices' ),
								'value'      => array( 'mobile' ),
								'operator'   => 'CONTAIN',
							),
							array(
								'value_path'          => array( 'logo_enabled_devices' ),
								'value'               => array( 'mobile' ),
								'operator'            => 'CONTAIN',
								'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
							),
							array(
								'devices' => array( 'tablet', 'mobile' ),
							),
						),
						array(
							array(
								'value_path' => array( 'tagline', 'enabled_devices' ),
								'value'      => array( 'desktop' ),
								'operator'   => 'CONTAIN',
							),
							array(
								'value_path'          => array( 'logo_enabled_devices' ),
								'value'               => array( 'desktop' ),
								'operator'            => 'CONTAIN',
								'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
							),
							array(
								'devices' => array( 'desktop' ),
							),
						),
						array(
							array(
								'value_path' => array( 'tagline', 'enabled_devices' ),
								'value'      => array( 'mobile' ),
								'operator'   => 'CONTAIN',
							),
							array(
								'value_path'          => array( 'logo_enabled_devices' ),
								'value'               => array( 'mobile' ),
								'operator'            => 'CONTAIN',
								'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
							),
							array(
								'devices' => array( 'tablet', 'mobile' ),
							),
						),
					),
				),
			),
			'content_alignment'       => array(
				'value_path'     => array( 'content_alignment' ),
				'title'          => array(
					'text' => __( 'Title & Tagline alignment', 'brandy' ),
				),
				'default_value'  => 'left',
				'type'           => 'Alignment',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-logo__content',
							'value_path'        => array( 'content_alignment' ),
							'mapping_variables' => array(
								array(
									'condition' => array(
										'operator' => 'equal',
										'value'    => 'left',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'align-items' => 'flex-start',
											'text-align'  => 'left',
										),
									),
								),
								array(
									'condition' => array(
										'operator' => 'equal',
										'value'    => 'center',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'align-items' => 'center',
											'text-align'  => 'center',
										),
									),
								),
								array(
									'condition' => array(
										'operator' => 'equal',
										'value'    => 'right',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'align-items' => 'flex-end',
											'text-align'  => 'right',
										),
									),
								),
							),
						),
					),
				),
			),
			'content_max_width'       => array(
				'value_path'     => array( 'content_max_width' ),
				'title'          => array(
					'text' => __( 'Content max width', 'brandy' ),
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 600,
						'value' => 300,
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
							'name'       => 'max-width',
							'selector'   => '.brandy-logo__content',
							'value_path' => array( 'content_max_width' ),
						),
					),
				),
			),
			'logo_spacing'            => array(
				'value_path'         => array( 'logo_spacing' ),
				'title'              => array(
					'text' => __( 'Spacing between logo & content', 'brandy' ),
				),
				'units'              => array( 'px' ),
				'default_value'      => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 50,
						'value' => 10,
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
							'name'       => 'gap',
							'selector'   => '.brandy-logo',
							'value_path' => array( 'logo_spacing' ),
						),
					),
				),
				'visible_conditions' => array(
					'groups' => array(
						array(
							array(
								'value_path' => array( 'title', 'enabled_devices' ),
								'value'      => array( 'desktop' ),
								'operator'   => 'CONTAIN',
							),
							array(
								'value_path'          => array( 'logo_enabled_devices' ),
								'value'               => array( 'desktop' ),
								'operator'            => 'CONTAIN',
								'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
							),
							array(
								'devices' => array( 'desktop' ),
							),
						),
						array(
							array(
								'value_path' => array( 'title', 'enabled_devices' ),
								'value'      => array( 'mobile' ),
								'operator'   => 'CONTAIN',
							),
							array(
								'value_path'          => array( 'logo_enabled_devices' ),
								'value'               => array( 'mobile' ),
								'operator'            => 'CONTAIN',
								'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
							),
							array(
								'devices' => array( 'tablet', 'mobile' ),
							),
						),
						array(
							array(
								'value_path' => array( 'tagline', 'enabled_devices' ),
								'value'      => array( 'desktop' ),
								'operator'   => 'CONTAIN',
							),
							array(
								'value_path'          => array( 'logo_enabled_devices' ),
								'value'               => array( 'desktop' ),
								'operator'            => 'CONTAIN',
								'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
							),
							array(
								'devices' => array( 'desktop' ),
							),
						),
						array(
							array(
								'value_path' => array( 'tagline', 'enabled_devices' ),
								'value'      => array( 'mobile' ),
								'operator'   => 'CONTAIN',
							),
							array(
								'value_path'          => array( 'logo_enabled_devices' ),
								'value'               => array( 'mobile' ),
								'operator'            => 'CONTAIN',
								'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
							),
							array(
								'devices' => array( 'tablet', 'mobile' ),
							),
						),
					),
				),
			),
			'content_spacing'         => array(
				'value_path'     => array( 'content_spacing' ),
				'title'          => array(
					'text' => __( 'Title & Tagline spacing', 'brandy' ),
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 0,
						'max'   => 50,
						'value' => 4,
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
							'selector'   => '.brandy-logo__content',
							'value_path' => array( 'content_spacing' ),
						),
					),
				),
			),
			'title_reset'             => array(
				'title'       => array(
					'text' => __( 'Title', 'brandy' ),
					'type' => 'bold',
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'title', 'color' ),
					array( 'title', 'typography' ),
					array( 'title', 'underline_when_hovering' ),
					array( 'title', 'underline_color' ),
					array( 'title', 'underline_size' ),
				),
			),
			'title_text_color'        => array(
				'title'          => array(
					'text'  => __( 'Text color', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'title', 'color' ),
				'default_value'  => array(
					'normal' => 'var(--wp--preset--color--brandy-primary-text)',
					'hover'  => 'var(--wp--preset--color--brandy-primary-text)',
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-title-color',
							'value_path' => array( 'title', 'color' ),
						),
					),
				),
			),
			'title_text_typography'   => array(
				'title'          => array(
					'text'  => __( 'Typography', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'title', 'typography' ),
				'default_value'  => null,
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-logo__title',
							'value_path' => array( 'title', 'typography' ),
						),
					),
				),
			),
			'title_hover_underline'   => array(
				'title'          => array(
					'text'  => __( 'Underline when hovering?', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'title', 'underline_when_hovering' ),
				'default_value'  => false,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-logo__title',
							'name'           => 'data-hover-underline',
							'value_path'     => array( 'title', 'underline_when_hovering' ),
							'enabled_value'  => 'true',
							'disabled_value' => 'false',
						),
					),
				),
			),
			'title_underline_color'   => array(
				'title'              => array(
					'text'  => __( 'Underline color', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'         => array( 'title', 'underline_color' ),
				'default_value'      => array(
					'normal' => 'var(--wp--preset--color--brandy-primary-text)',
				),
				'type'               => 'ColorGroup',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-title-underline-color',
							'value_path' => array( 'title', 'underline_color' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'title', 'underline_when_hovering' ),
						'value'      => true,
					),
				),
			),
			'title_underline_size'    => array(
				'title'              => array(
					'text'  => __( 'Underline size', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'         => array( 'title', 'underline_size' ),
				'default_value'      => array(
					'unit'  => 'px',
					'min'   => 0,
					'max'   => 10,
					'value' => 3,
				),
				'type'               => 'Dimension',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-title-underline-size',
							'value_path' => array( 'title', 'underline_size' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'title', 'underline_when_hovering' ),
						'value'      => true,
					),
				),
			),
			'tagline_reset'           => array(
				'title'       => array(
					'text' => __( 'Tagline', 'brandy' ),
					'type' => 'bold',
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'tagline' ),
				),
			),
			'tagline_text_color'      => array(
				'title'          => array(
					'text'  => __( 'Tagline color', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'tagline', 'color' ),
				'default_value'  => array(
					'normal' => 'var(--wp--preset--color--brandy-primary-text)',
					'hover'  => 'var(--wp--preset--color--brandy-primary-text)',
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-tagline-color',
							'value_path' => array( 'tagline', 'color' ),
						),
					),
				),
			),
			'tagline_text_typography' => array(
				'title'          => array(
					'text'  => __( 'Typography', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'tagline', 'typography' ),
				'default_value'  => null,
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-logo__tagline',
							'value_path' => array( 'tagline', 'typography' ),
						),
					),
				),
			),
			'padding'                 => array(
				'value_path'     => array( 'padding' ),
				'title'          => array(
					'text'         => 'Padding',
					'type'         => 'bold',
					'show_devices' => true,
				),
				'section'        => 'spacing_section',
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
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => 'padding',
							'selector'   => '.brandy-logo',
							'value_path' => array( 'padding' ),
						),
					),
				),
			),
			'margin'                  => array(
				'value_path'     => array( 'margin' ),
				'title'          => array(
					'text'         => 'Margin',
					'type'         => 'bold',
					'show_devices' => true,
				),
				'section'        => 'spacing_section',
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
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => 'margin',
							'selector'   => '.brandy-logo',
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
							'logo_enabled',
						),
					),
					array(
						'components'         => array(
							'logo_reset',
							'logo_url',
							'logo_height',
						),
						'visible_conditions' => array(
							'groups' => array(
								array(
									array(
										'value_path' => array( 'logo_enabled_devices' ),
										'value'      => array( 'desktop' ),
										'operator'   => 'CONTAIN',
										'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
									),
									array(
										'devices' => array( 'desktop' ),
									),
								),
							),
						),
					),
					array(
						'components'         => array(
							'logo_mobile_reset',
							'logo_mobile_url',
							'logo_mobile_height',
						),
						'visible_conditions' => array(
							'groups' => array(
								array(
									array(
										'value_path' => array( 'logo_enabled_devices' ),
										'value'      => array( 'mobile' ),
										'operator'   => 'CONTAIN',
										'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
									),
									array(
										'devices' => array( 'tablet', 'mobile' ),
									),
								),
							),
						),
					),
					array(
						'components'         => array(
							'sticky_logo_enabled',
							'sticky_logo_url',
							'sticky_logo_height',
						),
						'visible_conditions' => array(
							'groups' => array(
								array(
									array(
										'value_path' => array( 'logo_enabled_devices' ),
										'value'      => array( 'desktop' ),
										'operator'   => 'CONTAIN',
										'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
									),
									array(
										'devices' => array( 'desktop' ),
									),
								),
								array(
									array(
										'value_path' => array( 'logo_enabled_devices' ),
										'value'      => array( 'mobile' ),
										'operator'   => 'CONTAIN',
										'default_check_value' => self::NEW_VALUES['logo_enabled_devices'],
									),
									array(
										'devices' => array( 'tablet', 'mobile' ),
									),
								),
							),
						),
					),
					array(
						'components' => array(
							'title_text',
							'title_enabled',
						),
					),
					array(
						'components' => array(
							'tagline_text',
							'tagline_enabled',
						),
					),
					array(
						'components'         => array(
							'content_layout',
							'content_position',
							'content_alignment',
							'content_max_width',
							'logo_spacing',
							'content_spacing',
						),
						'visible_conditions' => array(
							'groups' => array(
								array(
									array(
										'value_path' => array( 'title', 'enabled_devices' ),
										'value'      => array( 'desktop' ),
										'operator'   => 'CONTAIN',
									),
									array(
										'devices' => array( 'desktop' ),
									),
								),
								array(
									array(
										'value_path' => array( 'title', 'enabled_devices' ),
										'value'      => array( 'mobile' ),
										'operator'   => 'CONTAIN',
									),
									array(
										'devices' => array( 'tablet', 'mobile' ),
									),
								),
								array(
									array(
										'value_path' => array( 'tagline', 'enabled_devices' ),
										'value'      => array( 'desktop' ),
										'operator'   => 'CONTAIN',
									),
									array(
										'devices' => array( 'desktop' ),
									),
								),
								array(
									array(
										'value_path' => array( 'tagline', 'enabled_devices' ),
										'value'      => array( 'mobile' ),
										'operator'   => 'CONTAIN',
									),
									array(
										'devices' => array( 'tablet', 'mobile' ),
									),
								),
							),
						),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components'         => array(
							'title_reset',
							'title_text_typography',
							'title_text_color',
							'title_hover_underline',
							'title_underline_color',
							'title_underline_size',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'title', 'enabled_devices' ),
								'value'      => array( 'desktop', 'mobile' ),
								'operator'   => 'CONTAIN',
							),
						),
					),
					array(
						'components'         => array(
							'tagline_reset',
							'tagline_text_typography',
							'tagline_text_color',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'tagline', 'enabled_devices' ),
								'value'      => array( 'desktop', 'mobile' ),
								'operator'   => 'CONTAIN',
							),
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
		$mapped_layout                = $this->map_layout( $layout );
		$layouts[ $this->element_id ] = $mapped_layout;
		return $layouts;
	}
}
