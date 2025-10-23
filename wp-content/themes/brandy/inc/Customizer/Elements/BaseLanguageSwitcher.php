<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\TypographyService;
use DirectoryIterator;

class BaseLanguageSwitcher extends AbstractBaseElement {

	protected $settings = array();

	protected $default_languages = array();

	public function template_path() {
		return 'template-parts/builder/elements/language_switcher';
	}

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
	  d="M11.25 8.25H5.5V9.75H12H15.6537C15.3621 11.7022 14.4295 13.7518 13.1542 15.4194C12.8615 15.8022 12.5564 16.1579 12.243 16.4833C11.7383 16.1749 11.3219 15.8377 10.9781 15.4802C9.6184 14.0661 9.25 12.1847 9.25 10H7.75C7.75 12.3153 8.1316 14.6839 9.89688 16.5198C10.2433 16.8801 10.6373 17.214 11.0839 17.5199C10.0459 18.3062 8.97414 18.75 8 18.75V20.25C9.57171 20.25 11.1299 19.4776 12.4915 18.3093C13.6293 18.83 15.0113 19.2238 16.68 19.4759L15.0675 24H16.7925L17.7163 21.3825H21.6084L22.53 24H24.2625L20.5125 13.5H18.81L17.1937 18.0347C15.7684 17.8384 14.6033 17.542 13.6503 17.1709C13.8923 16.9008 14.1246 16.6198 14.3458 16.3306C15.7848 14.4488 16.8701 12.0754 17.1681 9.75H18.5V8.25H12.75V6H11.25V8.25ZM18.3209 19.6695C18.6888 19.7018 19.0686 19.7283 19.4606 19.749L19.5394 18.251C19.2997 18.2384 19.0657 18.2236 18.8373 18.2065L19.6647 15.862L21.0671 19.845H18.259L18.3209 19.6695Z"
	  fill="' . BRANDY_ICON_COLOR_NORMAL . '"
	/>
  </svg>';

	protected function __construct() {
		$this->default_languages = array_values(
			array_filter(
				$this->get_available_languages(),
				function( $item ) {
					return in_array( $item['id'], array( 'en', 'fr' ), true );
				}
			)
		);

		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );

		parent::__construct();
	}

	/**
	 * Override base element
	 *
	 * @Override
	 */
	protected function register_components() {
		return array(
			'list_languages'                     => array(
				'value_path'    => array( 'languages' ),
				'default_value' => $this->default_languages,
				'type'          => 'ListLanguages',
			),
			'flag_icon_enabled'                  => array(
				'title'          => array(
					'text' => __( 'Show flag', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'show_flag' ),
				'type'           => 'Switcher',
				'default_value'  => false,
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-lang-flag',
							'name'           => 'class',
							'enabled_class'  => '',
							'disabled_class' => 'hidden',
							'value_path'     => array( 'show_flag' ),
						),
					),
				),
			),
			'flag_icon_style'                    => array(
				'value_path'         => array( 'flag_icon_style' ),
				'default_value'      => 'normal',
				'options'            => array(
					array(
						'label' => 'Normal',
						'value' => 'normal',
					),
					array(
						'label' => 'Rounded',
						'value' => 'rounded',
					),
					array(
						'label' => 'Square',
						'value' => 'square',
					),
				),
				'type'               => 'ButtonGroup',
				'render_options'     => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-lang-flag',
							'name'       => 'icon-style',
							'value_path' => array(
								'flag_icon_style',
							),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'show_flag' ),
						'value'      => true,
					),
				),
			),
			'flag_name_enabled'                  => array(
				'value_path'     => array( 'flag_name', 'display' ),
				'title'          => array(
					'text' => 'Show name',
					'type' => 'bold',
				),
				'default_value'  => true,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'type'           => 'switcher',
							'selector'       => '.brandy-lang-name',
							'name'           => 'class',
							'enabled_class'  => '',
							'disabled_class' => 'hidden',
							'value_path'     => array( 'flag_name', 'display' ),
						),
					),
				),
			),
			'flag_name_type'                     => array(
				'value_path'     => array( 'flag_name', 'name_type' ),
				'default_value'  => 'country_language',
				'options'        => array(
					array(
						'label' => 'Country language',
						'value' => 'country_language',
					),
					array(
						'label' => 'Country code',
						'value' => 'country_code',
					),
				),
				'type'           => 'ButtonGroup',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'show_type'                          => array(
				'title'          => array(
					'text' => __( 'Select show type', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'show_type' ),
				'default_value'  => 'dropdown',
				'options'        => array(
					array(
						'label' => 'Show all',
						'value' => 'all',
					),
					array(
						'label' => 'Dropdown',
						'value' => 'dropdown',
					),
				),
				'type'           => 'ButtonGroup',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'flag_icon_reset'                    => array(
				'type'        => 'Reset',
				'title'       => array(
					'text'         => __( 'Flag icon', 'brandy' ),
					'show_devices' => true,
					'type'         => 'bold',
				),
				'reset_paths' => array(
					array( 'flag_icon' ),
				),
			),
			'flag_icon_size'                     => array(
				'value_path'     => array( 'flag_icon', 'size' ),
				'title'          => array(
					'text' => 'Flag size',
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(
						array(
							'min'   => 10,
							'value' => 15,
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
							'selector'   => '.brandy-lang-flag',
							'name'       => '--b-flag-icon-size',
							'value_path' => array( 'flag_icon', 'size' ),
						),
					),
				),
			),
			'language_item_reset'                => array(
				'type'        => 'Reset',
				'title'       => array(
					'text'         => __( 'Language item', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'reset_paths' => array(
					array( 'language_item' ),
				),
			),
			'language_item_color'                => array(
				'value_path'         => array( 'language_item', 'color' ),
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
							'name'       => '--b-language-item-color',
							'selector'   => '.brandy-lang-option',
							'value_path' => array( 'language_item', 'color' ),
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
			'language_item_typography'           => array(
				'value_path'     => array( 'language_item', 'typography' ),
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
							'selector'   => '.brandy-lang-option',
							'value_path' => array( 'language_item', 'typography' ),
						),
					),
				),
			),
			'language_item_activator_typography' => array(
				'value_path'     => array( 'language_item', 'activator_typography' ),
				'title'          => array(
					'text' => __( 'Active typography', 'brandy' ),
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
							'selector'   => '.brandy-lang-option.selected',
							'value_path' => array( 'language_item', 'activator_typography' ),
						),
					),
				),
			),
			'language_item_background'           => array(
				'value_path'     => array( 'language_item', 'background' ),
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
							'name'       => '--b-language-item-background',
							'selector'   => '.brandy-lang-options',
							'value_path' => array( 'language_item', 'background' ),
						),
					),
				),
			),
			'language_item_stroke_color'         => array(
				'value_path'     => array( 'language_item', 'stroke_color' ),
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
							'name'       => '--b-language-item-stroke-color',
							'selector'   => '.brandy-lang-options',
							'value_path' => array( 'language_item', 'stroke_color' ),
						),
					),
				),
			),
			'language_item_stroke_width'         => array(
				'value_path'     => array( 'language_item', 'stroke_width' ),
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
							'name'       => '--b-language-item-stroke-width',
							'selector'   => '.brandy-lang-options',
							'value_path' => array( 'language_item', 'stroke_width' ),
						),
					),
				),
			),
			'language_item_border_radius'        => array(
				'value_path'     => array( 'language_item', 'border_radius' ),
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
							'name'       => '--b-language-item-border-radius',
							'selector'   => '.brandy-lang-options',
							'value_path' => array( 'language_item', 'border_radius' ),
						),
					),
				),
			),
			'language_item_spacing'              => array(
				'value_path'     => array( 'language_item', 'spacing' ),
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
							'selector'   => '.brandy-lang-options',
							'value_path' => array( 'language_item', 'spacing' ),
						),
					),
				),
			),
			'language_item_padding'              => array(
				'value_path'     => array( 'language_item', 'padding' ),
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
							'selector'   => '.brandy-lang-option',
							'value_path' => array( 'language_item', 'padding' ),
						),
					),
				),
			),
			'dropdown_reset'                     => array(
				'title'       => array(
					'text'         => __( 'Select Trigger', 'brandy' ),
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
							'selector'   => '.brandy-lang-switcher__placeholder',
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
							'selector'   => '.brandy-lang-switcher__placeholder',
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
							'selector'   => '.brandy-lang-switcher__placeholder',
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
							'selector'   => '.brandy-lang-switcher__placeholder',
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
							'selector'   => '.brandy-lang-switcher__placeholder',
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
				'default_value'  => null,
				'is_responsive'  => true,
				'type'           => 'Typography',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-lang-switcher__placeholder',
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
							'selector'   => '.brandy-lang-switcher__placeholder',
							'value_path' => array( 'activator', 'color' ),
						),
					),
				),
			),
			'select_content' => [
				'title' => [
					'text' => __( 'Select content', 'brandy' ),
					'type' => 'bold',
				],
				'type' => 'Reset',
				'reset_paths' => [
					array( 'dropdown_padding' ),
					['content_background'],
				],
			],
			'content_background' => [
				'title' => [
					'text' => __( 'Content background', 'brandy' ),
				],
				'value_path' => [ 'content_background' ],
				'type' => 'ColorGroup',
				'is_responsive'      => true,
				'default_value' => [
					'normal' => [
						'desktop' => '#ffffff',
						'tablet' => null,
						'mobile' => null,
					],
				],
				'render_options' => [
					'type' => 'variable',
					'data' => [
						[
							'type' => 'color',
							'name' => '--b-content-background',
							'value_path' => [ 'content_background' ],
							'selector' => '.brandy-element-wrapper[show-type="dropdown"] .brandy-lang-options',
						],
					],
				],
			],
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
							'selector'   => '.brandy-element-wrapper[show-type="dropdown"] .brandy-lang-options',
							'name'       => 'padding',
							'value_path' => array( 'dropdown_padding' ),
						),
					),
				),
			),
			'margin'                             => array(
				'value_path'     => array( 'margin' ),
				'title'          => array(
					'text'         => __( 'Margin', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
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
							'selector'   => '.brandy-lang-switcher-element',
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
							'list_languages',
						),
					),
					array(
						'components' => array( 'flag_icon_enabled', 'flag_icon_style' ),
					),
					array(
						'components' => array( 'flag_name_enabled', 'flag_name_type' ),
					),
					array(
						'components' => array(
							'show_type',
						),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components'         => array( 'flag_icon_reset', 'flag_icon_size' ),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'show_flag' ),
								'value'      => true,
							),
						),
					),
					array(
						'components'         => array( 'dropdown_reset', 'activator_typography', 'activator_color', 'activator_background', 'activator_stroke_color', 'activator_stroke_width', 'activator_border_radius', 'activator_padding' ),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'show_type' ),
								'value'      => 'dropdown',
							),
						),
					),
					array(
						'components'         => array( 'select_content', 'content_background', 'dropdown_padding' ),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'show_type' ),
								'value'      => 'dropdown',
							),
						),
					),
					array(
						'components' => array( 'language_item_reset', 'language_item_typography', 'language_item_activator_typography', 'language_item_color', 'language_item_background', 'language_item_stroke_color', 'language_item_stroke_width', 'language_item_border_radius', 'language_item_spacing', 'language_item_padding' ),
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
		if ( isset( $localize_data['language'] ) ) {
			return $localize_data;
		}
		$localize_data['language'] = array(
			'list'  => $this->get_available_languages(),
			'flags' => $this->get_flags(),
		);
		return $localize_data;
	}

	public function get_available_languages() {
		return array(

			array(
				'id'            => 'sq',
				'country_code'  => 'sq',
				'language_code' => 'sq',
				'language_name' => 'Albanian',
				'english_name'  => 'Albanian',
				'flag'          => 'sq',
				'url'           => '#',
			),
			array(
				'id'            => 'ar',
				'country_code'  => 'ar',
				'language_code' => 'ar',
				'language_name' => 'Arabic',
				'english_name'  => 'Arabic',
				'flag'          => 'ar',
				'url'           => '#',
			),
			array(
				'id'            => 'hy',
				'country_code'  => 'hy',
				'language_code' => 'hy',
				'language_name' => 'Armenian',
				'english_name'  => 'Armenian',
				'flag'          => 'hy',
				'url'           => '#',
			),
			array(
				'id'            => 'az',
				'country_code'  => 'az',
				'language_code' => 'az',
				'language_name' => 'Azerbaijani',
				'english_name'  => 'Azerbaijani',
				'flag'          => 'az',
				'url'           => '#',
			),
			array(
				'id'            => 'eu',
				'country_code'  => 'eu',
				'language_code' => 'eu',
				'language_name' => 'Basque',
				'english_name'  => 'Basque',
				'flag'          => 'eu',
				'url'           => '#',
			),
			array(
				'id'            => 'bn',
				'country_code'  => 'bn',
				'language_code' => 'bn',
				'language_name' => 'Bengali',
				'english_name'  => 'Bengali',
				'flag'          => 'bn',
				'url'           => '#',
			),
			array(
				'id'            => 'bs',
				'country_code'  => 'bs',
				'language_code' => 'bs',
				'language_name' => 'Bosnian',
				'english_name'  => 'Bosnian',
				'flag'          => 'bs',
				'url'           => '#',
			),
			array(
				'id'            => 'bg',
				'country_code'  => 'bg',
				'language_code' => 'bg',
				'language_name' => 'Bulgarian',
				'english_name'  => 'Bulgarian',
				'flag'          => 'bg',
				'url'           => '#',
			),
			array(
				'id'            => 'ca',
				'country_code'  => 'ca',
				'language_code' => 'ca',
				'language_name' => 'Catalan',
				'english_name'  => 'Catalan',
				'flag'          => 'es',
				'url'           => '#',
			),
			array(
				'id'            => 'zh-CN',
				'country_code'  => 'zh-CN',
				'language_code' => 'zh-CN',
				'language_name' => 'Chinese (Simplified)',
				'english_name'  => 'Chinese (Simplified)',
				'flag'          => 'zh',
				'url'           => '#',
			),
			array(
				'id'            => 'zh-TW',
				'country_code'  => 'zh-TW',
				'language_code' => 'zh-TW',
				'language_name' => 'Chinese (Traditional)',
				'english_name'  => 'Chinese (Traditional)',
				'flag'          => 'zh',
				'url'           => '#',
			),
			array(
				'id'            => 'hr',
				'country_code'  => 'hr',
				'language_code' => 'hr',
				'language_name' => 'Croatian',
				'english_name'  => 'Croatian',
				'flag'          => 'hr',
				'url'           => '#',
			),
			array(
				'id'            => 'cs',
				'country_code'  => 'cs',
				'language_code' => 'cs',
				'language_name' => 'Czech',
				'english_name'  => 'Czech',
				'flag'          => 'cs',
				'url'           => '#',
			),
			array(
				'id'            => 'da',
				'country_code'  => 'da',
				'language_code' => 'da',
				'language_name' => 'Danish',
				'english_name'  => 'Danish',
				'flag'          => 'da',
				'url'           => '#',
			),
			array(
				'id'            => 'nl',
				'country_code'  => 'nl',
				'language_code' => 'nl',
				'language_name' => 'Dutch',
				'english_name'  => 'Dutch',
				'flag'          => 'nl',
				'url'           => '#',
			),
			array(
				'id'            => 'en',
				'country_code'  => 'en',
				'language_code' => 'en',
				'language_name' => 'English',
				'english_name'  => 'English',
				'flag'          => 'en',
				'url'           => '#',
			),
			array(
				'id'            => 'eo',
				'country_code'  => 'eo',
				'language_code' => 'eo',
				'language_name' => 'Esperanto',
				'english_name'  => 'Esperanto',
				'flag'          => 'es',
				'url'           => '#',
			),
			array(
				'id'            => 'et',
				'country_code'  => 'et',
				'language_code' => 'et',
				'language_name' => 'Estonian',
				'english_name'  => 'Estonian',
				'flag'          => 'et',
				'url'           => '#',
			),
			array(
				'id'            => 'fi',
				'country_code'  => 'fi',
				'language_code' => 'fi',
				'language_name' => 'Finnish',
				'english_name'  => 'Finnish',
				'flag'          => 'fi',
				'url'           => '#',
			),
			array(
				'id'            => 'fr',
				'country_code'  => 'fr',
				'language_code' => 'fr',
				'language_name' => 'French',
				'english_name'  => 'French',
				'flag'          => 'fr',
				'url'           => '#',
			),
			array(
				'id'            => 'gl',
				'country_code'  => 'gl',
				'language_code' => 'gl',
				'language_name' => 'Galician',
				'english_name'  => 'Galician',
				'flag'          => 'es',
				'url'           => '#',
			),
			array(
				'id'            => 'de',
				'country_code'  => 'de',
				'language_code' => 'de',
				'language_name' => 'German',
				'english_name'  => 'German',
				'flag'          => 'de',
				'url'           => '#',
			),
			array(
				'id'            => 'el',
				'country_code'  => 'el',
				'language_code' => 'el',
				'language_name' => 'Greek',
				'english_name'  => 'Greek',
				'flag'          => 'el',
				'url'           => '#',
			),
			array(
				'id'            => 'iw',
				'country_code'  => 'iw',
				'language_code' => 'iw',
				'language_name' => 'Hebrew',
				'english_name'  => 'Hebrew',
				'flag'          => 'iw',
				'url'           => '#',
			),
			array(
				'id'            => 'hi',
				'country_code'  => 'hi',
				'language_code' => 'hi',
				'language_name' => 'Hindi',
				'english_name'  => 'Hindi',
				'flag'          => 'hi',
				'url'           => '#',
			),
			array(
				'id'            => 'hu',
				'country_code'  => 'hu',
				'language_code' => 'hu',
				'language_name' => 'Hungarian',
				'english_name'  => 'Hungarian',
				'flag'          => 'hu',
				'url'           => '#',
			),
			array(
				'id'            => 'is',
				'country_code'  => 'is',
				'language_code' => 'is',
				'language_name' => 'Icelandic',
				'english_name'  => 'Icelandic',
				'flag'          => 'is',
				'url'           => '#',
			),
			array(
				'id'            => 'id',
				'country_code'  => 'id',
				'language_code' => 'id',
				'language_name' => 'Indonesian',
				'english_name'  => 'Indonesian',
				'flag'          => 'id',
				'url'           => '#',
			),
			array(
				'id'            => 'ga',
				'country_code'  => 'ga',
				'language_code' => 'ga',
				'language_name' => 'Irish',
				'english_name'  => 'Irish',
				'flag'          => 'ga',
				'url'           => '#',
			),
			array(
				'id'            => 'it',
				'country_code'  => 'it',
				'language_code' => 'it',
				'language_name' => 'Italian',
				'english_name'  => 'Italian',
				'flag'          => 'it',
				'url'           => '#',
			),
			array(
				'id'            => 'ja',
				'country_code'  => 'ja',
				'language_code' => 'ja',
				'language_name' => 'Japanese',
				'english_name'  => 'Japanese',
				'flag'          => 'ja',
				'url'           => '#',
			),
			array(
				'id'            => 'ko',
				'country_code'  => 'ko',
				'language_code' => 'ko',
				'language_name' => 'Korean',
				'english_name'  => 'Korean',
				'flag'          => 'ko',
				'url'           => '#',
			),
			array(
				'id'            => 'ku',
				'country_code'  => 'ku',
				'language_code' => 'ku',
				'language_name' => 'Kurdish',
				'english_name'  => 'Kurdish',
				'flag'          => 'ku',
				'url'           => '#',
			),
			array(
				'id'            => 'lv',
				'country_code'  => 'lv',
				'language_code' => 'lv',
				'language_name' => 'Latvian',
				'english_name'  => 'Latvian',
				'flag'          => 'lv',
				'url'           => '#',
			),
			array(
				'id'            => 'lt',
				'country_code'  => 'lt',
				'language_code' => 'lt',
				'language_name' => 'Lithuanian',
				'english_name'  => 'Lithuanian',
				'flag'          => 'lt',
				'url'           => '#',
			),
			array(
				'id'            => 'mk',
				'country_code'  => 'mk',
				'language_code' => 'mk',
				'language_name' => 'Macedonian',
				'english_name'  => 'Macedonian',
				'flag'          => 'mk',
				'url'           => '#',
			),
			array(
				'id'            => 'ms',
				'country_code'  => 'ms',
				'language_code' => 'ms',
				'language_name' => 'Malay',
				'english_name'  => 'Malay',
				'flag'          => 'ms',
				'url'           => '#',
			),
			array(
				'id'            => 'mt',
				'country_code'  => 'mt',
				'language_code' => 'mt',
				'language_name' => 'Maltese',
				'english_name'  => 'Maltese',
				'flag'          => 'mt',
				'url'           => '#',
			),
			array(
				'id'            => 'mn',
				'country_code'  => 'mn',
				'language_code' => 'mn',
				'language_name' => 'Mongolian',
				'english_name'  => 'Mongolian',
				'flag'          => 'mn',
				'url'           => '#',
			),
			array(
				'id'            => 'ne',
				'country_code'  => 'ne',
				'language_code' => 'ne',
				'language_name' => 'Nepali',
				'english_name'  => 'Nepali',
				'flag'          => 'ne',
				'url'           => '#',
			),
			array(
				'id'            => 'no',
				'country_code'  => 'no',
				'language_code' => 'no',
				'language_name' => 'Norwegian',
				'english_name'  => 'Norwegian',
				'flag'          => 'no',
				'url'           => '#',
			),
			array(
				'id'            => 'fa',
				'country_code'  => 'fa',
				'language_code' => 'fa',
				'language_name' => 'Persian',
				'english_name'  => 'Persian',
				'flag'          => 'fa',
				'url'           => '#',
			),
			array(
				'id'            => 'pl',
				'country_code'  => 'pl',
				'language_code' => 'pl',
				'language_name' => 'Polish',
				'english_name'  => 'Polish',
				'flag'          => 'pl',
				'url'           => '#',
			),
			array(
				'id'            => 'pt-BR',
				'country_code'  => 'pt-BR',
				'language_code' => 'pt-BR',
				'language_name' => 'Portuguese (Brazil)',
				'english_name'  => 'Portuguese (Brazil)',
				'flag'          => 'pt-BR',
				'url'           => '#',
			),
			array(
				'id'            => 'pt-PT',
				'country_code'  => 'pt-PT',
				'language_code' => 'pt-PT',
				'language_name' => 'Portuguese (Portugal)',
				'english_name'  => 'Portuguese (Portugal)',
				'flag'          => 'pt-PT',
				'url'           => '#',
			),
			array(
				'id'            => 'pa',
				'country_code'  => 'pa',
				'language_code' => 'pa',
				'language_name' => 'Punjabi',
				'english_name'  => 'Punjabi',
				'flag'          => 'pa',
				'url'           => '#',
			),
			array(
				'id'            => 'ro',
				'country_code'  => 'ro',
				'language_code' => 'ro',
				'language_name' => 'Romanian',
				'english_name'  => 'Romanian',
				'flag'          => 'ro',
				'url'           => '#',
			),
			array(
				'id'            => 'ru',
				'country_code'  => 'ru',
				'language_code' => 'ru',
				'language_name' => 'Russian',
				'english_name'  => 'Russian',
				'flag'          => 'ru',
				'url'           => '#',
			),
			array(
				'id'            => 'sr',
				'country_code'  => 'sr',
				'language_code' => 'sr',
				'language_name' => 'Serbian',
				'english_name'  => 'Serbian',
				'flag'          => 'sr',
				'url'           => '#',
			),
			array(
				'id'            => 'sk',
				'country_code'  => 'sk',
				'language_code' => 'sk',
				'language_name' => 'Slovak',
				'english_name'  => 'Slovak',
				'flag'          => 'sk',
				'url'           => '#',
			),
			array(
				'id'            => 'sl',
				'country_code'  => 'sl',
				'language_code' => 'sl',
				'language_name' => 'Slovenian',
				'english_name'  => 'Slovenian',
				'flag'          => 'sl',
				'url'           => '#',
			),
			array(
				'id'            => 'so',
				'country_code'  => 'so',
				'language_code' => 'so',
				'language_name' => 'Somali',
				'english_name'  => 'Somali',
				'flag'          => 'so',
				'url'           => '#',
			),
			array(
				'id'            => 'es',
				'country_code'  => 'es',
				'language_code' => 'es',
				'language_name' => 'Spanish',
				'english_name'  => 'Spanish',
				'flag'          => 'es',
				'url'           => '#',
			),
			array(
				'id'            => 'qu',
				'country_code'  => 'qu',
				'language_code' => 'qu',
				'language_name' => 'Quechua',
				'english_name'  => 'Quechua',
				'flag'          => 'qu',
				'url'           => '#',
			),
			array(
				'id'            => 'sv',
				'country_code'  => 'sv',
				'language_code' => 'sv',
				'language_name' => 'Swedish',
				'english_name'  => 'Swedish',
				'flag'          => 'sv',
				'url'           => '#',
			),
			array(
				'id'            => 'ta',
				'country_code'  => 'ta',
				'language_code' => 'ta',
				'language_name' => 'Tamil',
				'english_name'  => 'Tamil',
				'flag'          => 'hi',
				'url'           => '#',
			),
			array(
				'id'            => 'th',
				'country_code'  => 'th',
				'language_code' => 'th',
				'language_name' => 'Thai',
				'english_name'  => 'Thai',
				'flag'          => 'th',
				'url'           => '#',
			),
			array(
				'id'            => 'tr',
				'country_code'  => 'tr',
				'language_code' => 'tr',
				'language_name' => 'Turkish',
				'english_name'  => 'Turkish',
				'flag'          => 'tr',
				'url'           => '#',
			),
			array(
				'id'            => 'uk',
				'country_code'  => 'uk',
				'language_code' => 'uk',
				'language_name' => 'Ukrainian',
				'english_name'  => 'Ukrainian',
				'flag'          => 'uk',
				'url'           => '#',
			),
			array(
				'id'            => 'ur',
				'country_code'  => 'ur',
				'language_code' => 'ur',
				'language_name' => 'Urdu',
				'english_name'  => 'Urdu',
				'flag'          => 'pa',
				'url'           => '#',
			),
			array(
				'id'            => 'uz',
				'country_code'  => 'uz',
				'language_code' => 'uz',
				'language_name' => 'Uzbek',
				'english_name'  => 'Uzbek',
				'flag'          => 'uz',
				'url'           => '#',
			),
			array(
				'id'            => 'vi',
				'country_code'  => 'vi',
				'language_code' => 'vi',
				'language_name' => 'Vietnamese',
				'english_name'  => 'Vietnamese',
				'flag'          => 'vi',
				'url'           => '#',
			),
			array(
				'id'            => 'cy',
				'country_code'  => 'cy',
				'language_code' => 'cy',
				'language_name' => 'Welsh',
				'english_name'  => 'Welsh',
				'flag'          => 'cy',
				'url'           => '#',
			),
			array(
				'id'            => 'zu',
				'country_code'  => 'zu',
				'language_code' => 'zu',
				'language_name' => 'Zulu',
				'english_name'  => 'Zulu',
				'flag'          => 'zu',
				'url'           => '#',
			),
		);
	}

	public function get_flags() {
		$flags = array();
		$dir   = new DirectoryIterator( BRANDY_TEMPLATE_DIR . '/template-parts/flags' );
		foreach ( $dir as $fileinfo ) {
			if ( ! $fileinfo->isDot() ) {
				$file_name = $fileinfo->getFilename();
				$file_path = BRANDY_TEMPLATE_DIR . "/template-parts/flags/$file_name";
				$flag      = basename( $file_name, '.svg' );
				if ( $file_name && file_exists( $file_path ) ) {
					ob_start();
					require $file_path;
					$flag_data = ob_get_contents();
					ob_end_clean();
					$flags[ $flag ] = $flag_data;
				}
			}
		}
		return $flags;
	}
}
