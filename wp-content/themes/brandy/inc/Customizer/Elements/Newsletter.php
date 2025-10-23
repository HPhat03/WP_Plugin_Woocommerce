<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\StringVariablesService;
use Brandy\Core\Services\TypographyService;
use Brandy\Traits\SingletonTrait;

class Newsletter extends AbstractBaseElement {

	use SingletonTrait;

	const DEFAULT_EMAIL_SUBJECT   = 'You have subscribed to our newsletter!';
	const DEFAULT_EMAIL_MESSAGE   = 'Thank you for subscribing to [site_title]!';
	const DEFAULT_SUCCESS_MESSAGE = 'Thank you for subscribing to our newsletter!';

	protected $element_id = 'newsletter';

	protected function __construct() {
		$this->title    = __( 'Newsletter', 'brandy' );
		$this->builders = array( 'footer' );
		$this->icon     = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.6665 10.8327C8.6665 9.16066 8.89367 8.41617 9.28017 8.02968C9.66666 7.64318 10.4111 7.41602 12.0832 7.41602H17.9165C19.5885 7.41602 20.333 7.64318 20.7195 8.02968C21.106 8.41617 21.3332 9.16066 21.3332 10.8327V16.75H10.2915C9.69685 16.75 9.14034 16.9171 8.6665 17.2069V10.8327ZM8.6665 19.875V19.9993V20.4167C8.6665 21.6108 9.63905 22.5833 10.8332 22.5833H19.1665C20.3606 22.5833 21.3332 21.6108 21.3332 20.4167V19.6286C21.325 19.5747 21.3227 19.5192 21.3267 19.4626C21.3329 19.377 21.3332 19.2871 21.3332 19.166V18.25H10.2915C9.39738 18.25 8.6665 18.9809 8.6665 19.875ZM22.8332 19.1925V20.4167C22.8332 22.4392 21.1891 24.0833 19.1665 24.0833H10.8332C8.81062 24.0833 7.1665 22.4392 7.1665 20.4167V19.9993V19.875V10.8327C7.1665 9.17138 7.356 7.83252 8.21951 6.96902C9.08301 6.10551 10.4219 5.91602 12.0832 5.91602H17.9165C19.5778 5.91602 20.9167 6.10551 21.7802 6.96902C22.6437 7.83252 22.8332 9.17138 22.8332 10.8327V17.5V19.166V19.1755V19.1756V19.1925ZM10.9165 10.834C10.9165 10.4198 11.2523 10.084 11.6665 10.084H18.3332C18.7474 10.084 19.0832 10.4198 19.0832 10.834C19.0832 11.2482 18.7474 11.584 18.3332 11.584H11.6665C11.2523 11.584 10.9165 11.2482 10.9165 10.834ZM11.6665 13C11.2523 13 10.9165 13.3358 10.9165 13.75C10.9165 14.1642 11.2523 14.5 11.6665 14.5H15.8332C16.2474 14.5 16.5832 14.1642 16.5832 13.75C16.5832 13.3358 16.2474 13 15.8332 13H11.6665Z" fill="' . BRANDY_ICON_COLOR_NORMAL . '"/></svg>';
		parent::__construct();
	}

	protected function register_components() {
		return array(
			'newsletter_title'           => array(
				'title'          => array(
					'text' => __( 'Title', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'TextInput',
				'value_path'     => array( 'newsletter_title' ),
				'default_value'  => 'Newsletter',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-newsletter-title',
							'value_path' => array( 'newsletter_title' ),
						),
					),
				),
			),
			'newsletter_subtitle'        => array(
				'title'          => array(
					'text' => __( 'Subtitle', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'TextInput',
				'value_path'     => array( 'newsletter_subtitle' ),
				'default_value'  => 'Be the first to know about exciting new designs, special events and much more.',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-newsletter-subtitle',
							'value_path' => array( 'newsletter_subtitle' ),
						),
					),
				),
			),
			'newsletter_note'            => array(
				'title'          => array(
					'text' => __( 'Note', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'TextInput',
				'value_path'     => array( 'newsletter_note' ),
				'default_value'  => 'We promise not send spam to you!',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-newsletter-note',
							'value_path' => array( 'newsletter_note' ),
						),
					),
				),
			),
			'placeholder'                => array(
				'title'          => array(
					'text' => __( 'Placeholder', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'TextInput',
				'value_path'     => array( 'placeholder' ),
				'default_value'  => 'Enter your email address',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-subscribe-box__input input',
							'name'       => 'placeholder',
							'value_path' => array( 'placeholder' ),
						),
					),
				),
			),
			'text_button'                => array(
				'title'          => array(
					'text' => __( 'Text button', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'TextInput',
				'value_path'     => array( 'text_button' ),
				'default_value'  => 'Subscribe',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-subscribe-box__button',
							'value_path' => array( 'text_button' ),
						),
					),
				),
			),
			'theme_layout_type'          => array(
				'title'          => array(
					'text' => __( 'Theme Layout', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'NewsletterLayoutType',
				'default_value'  => 'type_1',
				'value_path'     => array( 'theme_layout', 'type' ),
				'render_options' => array(
					'type' => 'force_refresh',
				),
				'options'        => array(
					array(
						'label' => __( 'Layout 1', 'brandy' ),
						'value' => 'type_1',
					),
					array(
						'label' => __( 'Layout 2', 'brandy' ),
						'value' => 'type_2',
					),
					array(
						'label' => __( 'Layout 3', 'brandy' ),
						'value' => 'type_3',
					),
				),
			),
			'horizontal_alignment'       => array(
				'title'          => array(
					'text'         => __( 'Horizontal Alignment', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'value_path'     => array( 'horizontal_align' ),
				'default_value'  => array(
					'desktop' => 'left',
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'type'           => 'Alignment',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-element-wrapper',
							'value_path'        => array( 'horizontal_align' ),
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
													'text-align' => 'left',
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
													'text-align' => 'right',
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
												'value'    => 'center',
											),
											'path'      => array( $device ),
											'mapping'   => array(
												$device => array(
													'text-align' => 'center',
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
			),
			'title_reset'                => array(
				'title'       => array(
					'text'         => __( 'Title text', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'title' ),
				),
			),
			'title_text_typography'      => array(
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
							'selector'   => '.brandy-newsletter-title',
							'value_path' => array( 'title', 'typography' ),
						),
					),
				),
			),
			'title_text_color'           => array(
				'title'          => array(
					'text'  => __( 'Text color', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'title', 'color' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--b-primary-text)',
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
							'name'       => '--b-title-text-color',
							'value_path' => array( 'title', 'color' ),
						),
					),
				),
			),
			'subtitle_reset'             => array(
				'title'       => array(
					'text'         => __( 'Subtitle text', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'subtitle' ),
				),
			),
			'subtitle_typography'        => array(
				'title'          => array(
					'text'  => __( 'Typography', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'subtitle', 'typography' ),
				'default_value'  => null,
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-newsletter-subtitle',
							'value_path' => array( 'subtitle', 'typography' ),
						),
					),
				),
			),
			'subtitle_text_color'        => array(
				'title'          => array(
					'text'  => __( 'Text color', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'subtitle', 'color' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--b-secondary-text)',
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
							'name'       => '--b-subtitle-text-color',
							'value_path' => array( 'subtitle', 'color' ),
						),
					),
				),
			),
			'note_reset'                 => array(
				'title'       => array(
					'text'         => __( 'Note text', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'note' ),
				),
			),
			'note_typography'            => array(
				'title'          => array(
					'text'  => __( 'Typography', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'note', 'typography' ),
				'default_value'  => null,
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-newsletter-note',
							'value_path' => array( 'note', 'typography' ),
						),
					),
				),
			),
			'note_text_color'            => array(
				'title'          => array(
					'text'  => __( 'Text color', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'note', 'color' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--b-secondary-text)',
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
							'name'       => '--b-note-text-color',
							'value_path' => array( 'note', 'color' ),
						),
					),
				),
			),
			'input_box_reset'            => array(
				'title'       => array(
					'text'         => __( 'Input box', 'brandy' ),
					'show_devices' => true,
					'type'         => 'bold',
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'input_box' ),
				),
			),
			'input_box_background_color' => array(
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
				'value_path'     => array( 'input_box', 'background_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-input-box-bg-color',
							'value_path' => array( 'input_box', 'background_color' ),
						),
					),
				),
			),
			'input_box_text_color'       => array(
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--b-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--b-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'  => true,
				'value_path'     => array( 'input_box', 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-input-box-text-color',
							'value_path' => array( 'input_box', 'color' ),
						),
					),
				),
			),
			'input_box_text_typography'  => array(
				'title'          => array(
					'text'  => __( 'Typography', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'input_box', 'typography' ),
				'default_value'  => [
					'font_size' => [
						"desktop" => [
							"unit" => "px",
							"value" => 14,
							"min" => 1,
							"max" => 30
						],
						"tablet" => null,
						"mobile" => null
					]
				],
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-subscribe-box',
							'name'       => '--b-input-box-typography',
							'value_path' => array( 'input_box', 'typography' ),
						),
					),
				),
			),
			'input_box_stroke_color'     => array(
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
						'desktop' => '#E3E8EE',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => 'var(--wp--preset--color--b-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'  => true,
				'value_path'     => array( 'input_box', 'stroke_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-input-box-stroke-color',
							'value_path' => array( 'input_box', 'stroke_color' ),
						),
					),
				),
			),
			'input_box_stroke_width'     => array(
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
				'value_path'     => array( 'input_box', 'stroke', 'width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-input-box-stroke-width',
							'value_path' => array( 'input_box', 'stroke', 'width' ),
						),
					),
				),
			),
			'input_box_border_radius'    => array(
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
				'value_path'     => array( 'input_box', 'border_radius' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-input-box-border-radius',
							'value_path' => array( 'input_box', 'border_radius' ),
						),
					),
				),
			),
			'input_box_input_height'     => array(
				'title'          => array(
					'text' => __( 'Input height', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 48,
						'min'   => 20,
						'max'   => 200,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'input_box', 'input_height' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-input-box-input-height',
							'value_path' => array( 'input_box', 'input_height' ),
						),
					),
				),
			),
			// 'input_box_input_width'      => array(
			// 	'title'          => array(
			// 		'text' => __( 'Input width', 'brandy' ),
			// 		'type' => 'normal',
			// 	),
			// 	'type'           => 'Dimension',
			// 	'default_value'  => array(
			// 		'desktop' => array(
			// 			'unit'  => '%',
			// 			'value' => 100,
			// 			'min'   => 1,
			// 			'max'   => 1000,
			// 		),
			// 		'tablet'  => null,
			// 		'mobile'  => null,
			// 	),
			// 	'is_responsive'  => true,
			// 	'value_path'     => array( 'input_box', 'input_width' ),
			// 	'render_options' => array(
			// 		'type' => 'variable',
			// 		'data' => array(
			// 			array(
			// 				'type'       => 'dimension',
			// 				'name'       => '--b-input-box-input-width',
			// 				'value_path' => array( 'input_box', 'input_width' ),
			// 			),
			// 		),
			// 	),
			// ),
			'element_width'              => array(
				'title'          => array(
					'text'         => __( 'Element width', 'brandy' ),
					'show_devices' => true,
					'type'         => 'bold',
				),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => array(
						'unit'  => '%',
						'value' => 70,
						'min'   => 20,
						'max'   => 1000,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'element_width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-element-wrapper',
							'name'       => 'width',
							'value_path' => array( 'element_width' ),
						),
					),
				),
			),
			'button_reset'               => array(
				'title'       => array(
					'text'         => __( 'Button', 'brandy' ),
					'show_devices' => true,
					'type'         => 'bold',
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'button' ),
				),
			),
			'button_text_color'          => array(
				'title'          => array(
					'text'  => __( 'Text color', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'button', 'text_color' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#ffffff',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--b-primary-text)',
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
							'name'       => '--b-button-text_color',
							'value_path' => array( 'button', 'text_color' ),
						),
					),
				),
			),
			'button_text_typography'     => array(
				'title'          => array(
					'text'  => __( 'Typography', 'brandy' ),
					'style' => 'normal',
				),
				'value_path'     => array( 'button', 'typography' ),
				'default_value'  => null,
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-subscribe-box__button',
							'value_path' => array( 'button', 'typography' ),
						),
					),
				),
			),
			'button_background_color'    => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--b-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--b-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'  => true,
				'value_path'     => array( 'button', 'background_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-button-bg-color',
							'value_path' => array( 'button', 'background_color' ),
						),
					),
				),
			),
			'button_stroke_color'        => array(
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
				),
				'is_responsive'  => true,
				'value_path'     => array( 'button', 'stroke_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-button-stroke-color',
							'value_path' => array( 'button', 'stroke_color' ),
						),
					),
				),
			),
			'button_stroke_width'        => array(
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
				'value_path'     => array( 'button', 'stroke', 'width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-subscribe-box__button',
							'name'       => 'border-width',
							'value_path' => array( 'button', 'stroke', 'width' ),
						),
					),
				),
			),
			'button_border_radius'       => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'value_path'     => array( 'button', 'border_radius' ),
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-subscribe-box__button',
							'name'       => 'border-radius',
							'value_path' => array( 'button', 'border_radius' ),
						),
					),
				),
			),
			'button_margin'              => array(
				'value_path'     => array( 'button', 'margin' ),
				'title'          => array(
					'text'         => 'Button margin',
					'show_devices' => true,
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 0,
						'right'          => 0,
						'bottom'         => 0,
						'left'           => 10,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'selector'   => '.brandy-subscribe-box__button',
							'name'       => 'margin',
							'value_path' => array( 'button', 'margin' ),
						),
					),
				),
			),
			'button_padding'             => array(
				'value_path'     => array( 'button', 'padding' ),
				'title'          => array(
					'text'         => 'Button padding',
					'show_devices' => true,
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 5,
						'right'          => 15,
						'bottom'         => 5,
						'left'           => 15,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'selector'   => '.brandy-subscribe-box__button',
							'name'       => 'padding',
							'value_path' => array( 'button', 'padding' ),
						),
					),
				),
			),
			'button_min_width'           => array(
				'title'          => array(
					'text' => __( 'Min width', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 90,
						'min'   => 0,
						'max'   => 500,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'button', 'min_width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-subscribe-box__button',
							'name'       => 'min-width',
							'value_path' => array( 'button', 'min_width' ),
						),
					),
				),
			),
			'button_box_shadow'          => array(
				'title'          => array(
					'text' => __( 'Box shadow', 'brandy' ),
				),
				'type'           => 'BoxShadow',
				'default_value'  => array(
					'enabled'      => false,
					'type'         => 'default',
					'custom_value' => array(
						'color'  => '#c4c3c3',
						'x'      => 3,
						'y'      => 3,
						'blur'   => 6,
						'spread' => 1,
					),
				),
				'value_path'     => array( 'button', 'box_shadow' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'box_shadow',
							'selector'   => '.brandy-subscribe-box__button',
							'name'       => 'box-shadow',
							'value_path' => array( 'button', 'box_shadow' ),
						),
					),
				),
			),
			'margin'                     => array(
				'value_path'     => array( 'margin' ),
				'title'          => array(
					'text'         => 'Margin',
					'type'         => 'bold',
					'show_devices' => true,
				),
				'section'        => 'spacing_section',
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
				'is_responsive'  => true,
				'type'           => 'Spacing',
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
			'email_subject'              => array(
				'type'          => 'TextInput',
				'title'         => array(
					'text' => __( 'Email subject', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'    => array( 'email_subject' ),
				'default_value' => self::DEFAULT_EMAIL_SUBJECT,
			),
			'email_message'              => array(
				'type'          => 'HTML',
				'title'         => array(
					'text' => __( 'Email message', 'brandy' ),
				),
				'description'   => sprintf( __( 'Arbitrary HTML code or shortcode. Available tags: %s', 'brandy' ), StringVariablesService::get_string_list_variables() ),
				'value_path'    => array( 'email_message' ),
				'default_value' => self::DEFAULT_EMAIL_MESSAGE,
			),
			'success_message'            => array(
				'type'          => 'TextInput',
				'title'         => array(
					'text' => __( 'Success message', 'brandy' ),
				),
				'value_path'    => array( 'success_message' ),
				'default_value' => self::DEFAULT_SUCCESS_MESSAGE,
			),
		);
	}

	public function add_layout( $layouts = array() ) {
		$layout = array(
			'general' => array(
				'sections' => array(
					array(
						'components' => array( 'newsletter_title' ),
					),
					array(
						'components' => array( 'newsletter_subtitle' ),
					),
					array(
						'components' => array( 'newsletter_note' ),
					),
					array(
						'components' => array( 'placeholder' ),
					),
					array(
						'components' => array( 'text_button' ),
					),
					array(
						'components' => array( 'theme_layout_type' ),
					),
					array(
						'components' => array( 'horizontal_alignment' ),
					),
					array(
						'components' => array( 'email_subject', 'email_message', 'success_message' ),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array(
							'title_reset',
							'title_text_typography',
							'title_text_color',
						),
					),
					array(
						'components' => array(
							'subtitle_reset',
							'subtitle_typography',
							'subtitle_text_color',
						),
					),
					array(
						'components' => array(
							'note_reset',
							'note_typography',
							'note_text_color',
						),
					),
					array(
						'components' => array( 'element_width' ),
					),
					array(
						'components' => array(
							'input_box_reset',
							'input_box_text_typography',
							'input_box_text_color',
							'input_box_background_color',
							'input_box_stroke_color',
							'input_box_stroke_width',
							'input_box_border_radius',
							'input_box_input_height',
							// 'input_box_input_width',
						),
					),
					array(
						'components' => array(
							'button_reset',
							'button_min_width',
							'button_text_color',
							'button_text_typography',
							'button_background_color',
							'button_stroke_color',
							'button_stroke_width',
							'button_border_radius',
							'button_padding',
							'button_margin',
							'button_box_shadow',
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
