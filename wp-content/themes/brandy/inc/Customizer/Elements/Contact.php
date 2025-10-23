<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\TypographyService;
use Brandy\Traits\SingletonTrait;

class Contact extends AbstractBaseElement {

	use SingletonTrait;

	protected $element_id = 'contact';

	protected $default_contacts = array();

	protected $builders = array( 'header', 'footer' );

	public static $path_to_icons = '/template-parts/icons/contact/';

	protected $title = 'Contact';

	protected $icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M8.6665 10.8327C8.6665 9.16066 8.89367 8.41617 9.28017 8.02968C9.66666 7.64318 10.4111 7.41602 12.0832 7.41602H17.9165C19.5885 7.41602 20.333 7.64318 20.7195 8.02968C21.106 8.41617 21.3332 9.16066 21.3332 10.8327V16.75H10.2915C9.69685 16.75 9.14034 16.9171 8.6665 17.2069V10.8327ZM8.6665 19.875V19.9993V20.4167C8.6665 21.6108 9.63905 22.5833 10.8332 22.5833H19.1665C20.3606 22.5833 21.3332 21.6108 21.3332 20.4167V19.6286C21.325 19.5747 21.3227 19.5192 21.3267 19.4626C21.3329 19.377 21.3332 19.2871 21.3332 19.166V18.25H10.2915C9.39738 18.25 8.6665 18.9809 8.6665 19.875ZM22.8332 19.1925V20.4167C22.8332 22.4392 21.1891 24.0833 19.1665 24.0833H10.8332C8.81062 24.0833 7.1665 22.4392 7.1665 20.4167V19.9993V19.875V10.8327C7.1665 9.17138 7.356 7.83252 8.21951 6.96902C9.08301 6.10551 10.4219 5.91602 12.0832 5.91602H17.9165C19.5778 5.91602 20.9167 6.10551 21.7802 6.96902C22.6437 7.83252 22.8332 9.17138 22.8332 10.8327V17.5V19.166V19.1755V19.1756V19.1925ZM10.9165 10.834C10.9165 10.4198 11.2523 10.084 11.6665 10.084H18.3332C18.7474 10.084 19.0832 10.4198 19.0832 10.834C19.0832 11.2482 18.7474 11.584 18.3332 11.584H11.6665C11.2523 11.584 10.9165 11.2482 10.9165 10.834ZM11.6665 13C11.2523 13 10.9165 13.3358 10.9165 13.75C10.9165 14.1642 11.2523 14.5 11.6665 14.5H15.8332C16.2474 14.5 16.5832 14.1642 16.5832 13.75C16.5832 13.3358 16.2474 13 15.8332 13H11.6665Z" fill="' . BRANDY_ICON_COLOR_NORMAL . '"/>
			</svg>
			';

	protected function __construct() {
		$this->default_contacts = array_values(
			array_filter(
				$this->get_all_contacts(),
				function( $item ) {
					return in_array( $item['id'], array( 'email', 'address' ), true );
				}
			)
		);

		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );

		parent::__construct();
	}

	protected function register_components() {
		return array(
			'list_contacts'         => array(
				'title'          => array(
					'text' => __( 'List contact', 'brandy' ),
				),
				'value_path'     => array( 'items' ),
				'default_value'  => $this->default_contacts,
				'type'           => 'ListContacts',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'target'                => array(
				'title'          => array(
					'text' => __( 'Open links in new tab', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'default_value'  => true,
				'value_path'     => array( 'target' ),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'       => '.brandy-contact-item',
							'name'           => 'target',
							'value_path'     => array( 'target' ),
							'enabled_value'  => '_blank',
							'disabled_value' => '_self',
						),
					),
				),
			),
			'items_direction'       => array(
				'title'          => array(
					'text'         => __( 'Item Direction', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'           => 'ButtonGroup',
				'default_value'  => array(
					'desktop' => 'row',
					'tablet'  => null,
					'mobile'  => null,
				),
				'options'        => array(
					array(
						'label' => __( 'Horizontal', 'brandy' ),
						'value' => 'row',
					),
					array(
						'label' => __( 'Vertical', 'brandy' ),
						'value' => 'column',
					),
				),
				'value_path'     => array( 'items_direction' ),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-contact-list',
							'name'       => 'items-direction-desktop',
							'value_path' => array( 'items_direction', 'desktop' ),
						),
						array(
							'selector'   => '.brandy-contact-list',
							'name'       => 'items-direction-tablet',
							'value_path' => array( 'items_direction', 'tablet' ),
						),
						array(
							'selector'   => '.brandy-contact-list',
							'name'       => 'items-direction-mobile',
							'value_path' => array( 'items_direction', 'mobile' ),
						),
					),
				),
			),
			'items_alignment'       => array(
				'title'          => array(
					'text' => __( 'Items alignment', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'HorizontalAlignment',
				'default_value'  => 'center',
				'value_path'     => array( 'items_alignment' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-contact-list',
							'value_path'        => array( 'items_alignment' ),
							'mapping_variables' => array(
								array(
									'condition' => array(
										'value'    => 'center',
										'operator' => 'equal',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'--b-align-items' => 'center',
										),
									),
								),
								array(
									'condition' => array(
										'value'    => 'left',
										'operator' => 'equal',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'--b-align-items' => 'flex-start',
										),
									),
								),
								array(
									'condition' => array(
										'value'    => 'right',
										'operator' => 'equal',
									),
									'path'      => array(),
									'mapping'   => array(
										'desktop' => array(
											'--b-align-items' => 'flex-end',
										),
									),
								),
							),
						),
					),
				),
			),
			'label_position'        => array(
				'value_path'     => array( 'label_position' ),
				'title'          => array(
					'text'         => __( 'Label position', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'default_value'  => array(
					'desktop' => 'bottom',
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Position',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'              => 'custom_variables',
							'selector'          => '.brandy-contact-item',
							'value_path'        => array( 'label_position' ),
							'mapping_variables' => array_merge(
								array_map(
									function( $device ) {
										return array(
											'condition' => array(
												'value'    => 'bottom',
												'operator' => 'equal',
											),
											'path'      => array( $device ),
											'mapping'   => array(
												$device => array(
													'--b-' . $device . '-direction' => 'column',
													'--b-' . $device . '-align-items' => 'center',
													'--b-' . $device . '-justify-content' => 'center',
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
												'value'    => 'left',
												'operator' => 'equal',
											),
											'path'      => array( $device ),
											'mapping'   => array(
												$device => array(
													'--b-' . $device . '-direction' => 'row-reverse',
													'--b-' . $device . '-align-items' => 'center',
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
												'value'    => 'right',
												'operator' => 'equal',
											),
											'path'      => array( $device ),
											'mapping'   => array(
												$device => array(
													'--b-' . $device . '-direction' => 'row',
													'--b-' . $device . '-align-items' => 'center',
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
			'icon_reset'            => array(
				'title'       => array(
					'text'         => __( 'Icon', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'icon' ),
				),
			),
			'icon_color'            => array(
				'title'          => array(
					'text' => __( 'Icon color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'icon', 'color' ),
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
							'value_path' => array( 'icon', 'color' ),
							'name'       => '--b-icon-color',
						),
					),
				),
			),
			'icon_background_color' => array(
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
							'value_path' => array( 'icon', 'background' ),
							'name'       => '--b-icon-background',
						),
					),
				),
			),
			'icon_stroke_color'     => array(
				'title'          => array(
					'text' => __( 'Stroke color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'icon', 'stroke', 'color' ),
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
							'value_path' => array( 'icon', 'stroke', 'color' ),
							'name'       => '--b-icon-stroke-color',
						),
					),
				),
			),
			'icon_stroke_width'     => array(
				'title'          => array(
					'text' => __( 'Stroke width', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'value_path'     => array( 'icon', 'stroke', 'width' ),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 1,
						'min'   => 0,
						'max'   => 20,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'value_path' => array( 'icon', 'stroke', 'width' ),
							'name'       => '--b-icon-stroke-width',
						),
					),
				),
			),
			'icon_border_radius'    => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'value_path'     => array( 'icon', 'border_radius' ),
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'value_path' => array( 'icon', 'border_radius' ),
							'name'       => '--b-icon-border-radius',
						),
					),
				),
			),
			'icon_size'             => array(
				'title'          => array(
					'text' => __( 'Icon size', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'value_path'     => array( 'icon', 'size' ),
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
							'value_path' => array( 'icon', 'size' ),
							'name'       => '--b-icon-size',
						),
					),
				),
			),
			'text_reset'            => array(
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
			'text_typography'       => array(
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
							'selector'   => '.brandy-contact-item__text',
							'value_path' => array( 'text', 'typography' ),
						),
					),
				),
			),
			'text_color'            => array(
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
							'value_path' => array( 'text', 'color' ),
							'name'       => '--b-text-color',
						),
					),
				),
			),
			'item_spacing'          => array(
				'title'          => array(
					'text' => __( 'Item Spacing', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Dimension',
				'value_path'     => array( 'item_spacing' ),
				'default_value'  => array(
					'unit'  => 'px',
					'value' => 14,
					'min'   => 0,
					'max'   => 200,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-contact-list',
							'name'       => 'gap',
							'value_path' => array( 'item_spacing' ),
						),
					),
				),
			),
			'margin'                => array(
				'title'          => array(
					'text'         => __( 'Margin', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'value_path'     => array( 'margin' ),
				'type'           => 'Spacing',
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
						'components' => array( 'list_contacts' ),
					),
					array(
						'components' => array( 'target' ),
					),
					array(
						'components' => array( 'items_direction' ),
					),
					array(
						'visible_conditions' => array(
							array(
								'value_path' => array( 'items_direction' ),
								'value'      => 'column',
							),
						),
						'components'         => array( 'items_alignment' ),
					),
					array(
						'components' => array( 'label_position' ),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array(
							'icon_reset',
							'icon_color',
							'icon_background_color',
							'icon_stroke_color',
							'icon_stroke_width',
							'icon_border_radius',
							'icon_size',
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
		$icons = array();
		$dir   = new \DirectoryIterator( BRANDY_TEMPLATE_DIR . self::$path_to_icons );
		foreach ( $dir as $fileinfo ) {
			if ( ! $fileinfo->isDot() ) {
				$file_name = $fileinfo->getFilename();
				$file_path = BRANDY_TEMPLATE_DIR . self::$path_to_icons . "$file_name";
				$icon_name = basename( $file_name, '.php' );
				if ( $file_name && file_exists( $file_path ) ) {
					if ( empty( $icons ) ) {
						$icons = array();
					}
					ob_start();
					require $file_path;
					$icon_data = ob_get_contents();
					ob_end_clean();
					$icons[ $icon_name ] = $icon_data;
				}
			}
		}
		$localize_data['icons']['contact'] = $icons;
		$localize_data['all_contacts']     = $this->get_all_contacts();
		return $localize_data;
	}

	public static function get_all_contacts() {
		return array(
			array(
				'id'      => 'email',
				'label'   => __( 'Email', 'brandy' ),
				'url'     => 'mailto:test@gmail.com',
				'icon'    => 'email',
				'content' => 'test@gmail.com',
				'visible' => true,
			),
			array(
				'id'      => 'phone',
				'label'   => __( 'Phone number', 'brandy' ),
				'url'     => 'tel:222-222-222',
				'icon'    => 'phone',
				'content' => '222-222-222',
				'visible' => true,
			),
			array(
				'id'      => 'link',
				'label'   => __( 'Link', 'brandy' ),
				'url'     => '#',
				'icon'    => 'link',
				'content' => 'www.test.com',
				'visible' => true,
			),
			array(
				'id'      => 'address',
				'label'   => __( 'Address', 'brandy' ),
				'url'     => '',
				'icon'    => 'address',
				'content' => 'New York',
				'visible' => true,
			),
			array(
				'id'      => 'website',
				'label'   => __( 'Website', 'brandy' ),
				'url'     => 'www.test.com',
				'icon'    => 'website',
				'content' => 'www.test.com',
				'visible' => true,
			),
			array(
				'id'      => 'fax',
				'label'   => __( 'Fax', 'brandy' ),
				'url'     => 'fax:254254254',
				'icon'    => 'fax',
				'content' => '254 254 254',
				'visible' => true,
			),
		);
	}

}
