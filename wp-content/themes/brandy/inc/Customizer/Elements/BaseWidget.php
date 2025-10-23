<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;

class BaseWidget extends AbstractBaseElement {

	protected $element_id = 'widget';

	protected $title = 'Widget';

	protected $builders = array( 'header', 'footer' );

	protected $icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M25 15C25 9.49 20.51 5 15 5C9.48 5 5 9.49 5 15C5 20.52 9.48 25 15 25C20.51 25 25 20.52 25 15ZM12.78 20.37L9.37 11.22C9.92 11.2 10.54 11.14 10.54 11.14C11.04 11.08 10.98 10.01 10.48 10.03C10.48 10.03 9.03 10.14 8.11 10.14C7.93 10.14 7.74 10.14 7.53 10.13C9.12 7.69 11.87 6.11 15 6.11C17.33 6.11 19.45 6.98 21.05 8.45C20.37 8.34 19.4 8.84 19.4 10.03C19.4 10.77 19.85 11.39 20.3 12.13C20.65 12.74 20.85 13.49 20.85 14.59C20.85 16.08 19.45 19.59 19.45 19.59L16.42 11.22C16.96 11.2 17.24 11.05 17.24 11.05C17.74 11 17.68 9.8 17.18 9.83C17.18 9.83 15.74 9.95 14.8 9.95C13.93 9.95 12.47 9.83 12.47 9.83C11.97 9.8 11.91 11.03 12.41 11.05L13.33 11.13L14.59 14.54L12.78 20.37ZM22.41 15C22.65 14.36 23.15 13.13 22.84 10.75C23.54 12.04 23.89 13.46 23.89 15C23.89 18.29 22.16 21.24 19.49 22.78C20.46 20.19 21.43 17.58 22.41 15ZM11.1 23.09C8.12 21.65 6.11 18.53 6.11 15C6.11 13.7 6.34 12.52 6.83 11.41C8.25 15.3 9.67 19.2 11.1 23.09ZM15.13 16.46L17.71 23.44C16.85 23.73 15.95 23.89 15 23.89C14.21 23.89 13.43 23.78 12.71 23.56C13.52 21.18 14.33 18.82 15.13 16.46Z" fill="' . BRANDY_ICON_COLOR_NORMAL . '"/>
			</svg>
			';

	protected function __construct() {

		add_action( 'widgets_init', array( $this, 'register_header_sidebars' ), 10 );

		add_action( 'widgets_init', array( $this, 'register_footer_sidebars' ), 100 );

		parent::__construct();
	}

	public function register_header_sidebars() {
		register_sidebar(
			array(
				'name'               => 'Header ' . $this->title,
				'configuration_type' => 'sidebar',
				'id'                 => 'header_' . $this->element_id,
				'description'        => esc_html__( 'Add widgets here:', 'brandy' ),
				'before_widget'      => '<section id="%1$s" class="widget %2$s">',
				'after_widget'       => '</section>',
				'before_title'       => '<h2 class="widget-title">',
				'after_title'        => '</h2>',
			)
		);
	}

	public function register_footer_sidebars() {
		register_sidebar(
			array(
				'name'               => 'Footer ' . $this->title,
				'configuration_type' => 'sidebar',
				'id'                 => 'footer_' . $this->element_id,
				'description'        => esc_html__( 'Add widgets here:', 'brandy' ),
				'before_widget'      => '<section id="%1$s" class="widget %2$s">',
				'after_widget'       => '</section>',
				'before_title'       => '<h2 class="widget-title">',
				'after_title'        => '</h2>',
			)
		);
	}

	public function template_path() {
		return 'template-parts/builder/elements/widget';
	}

	protected function register_components() {
		return array(
			'content'              => array(
				'type'          => defined( 'BRANDY_BLOCKS_VERSION' ) ? 'Widget' : 'FlexibleContent',
				'title'         => array(
					'text' => __( 'Widget content', 'brandy' ),
					'type' => 'bold',
				),
				'content'       => __( 'Please install Brandy Block to edit widget', 'brandy' ),
				'default_value' => '',
				'value_path'    => array( 'content' ),
			),
			'horizontal_alignment' => array(
				'title'          => array(
					'text'         => __( 'Horizontal Alignment', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'           => 'HorizontalAlignment',
				'default_value'  => array(
					'desktop' => 'left',
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'horizontal_alignment' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'name'       => '--brandy-text-align',
							'value_path' => array( 'horizontal_alignment' ),
						),
					),
				),
			),
			'vertical_alignment'   => array(
				'title'          => array(
					'text'         => __( 'Vertical alignment', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'           => 'VerticalAlignment',
				'default_value'  => array(
					'desktop' => 'top',
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'vertical_alignment' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'name'       => '--brandy-vertical-align',
							'value_path' => array( 'vertical_alignment' ),
						),
					),
				),
			),
			'font_color'           => array(
				'title'          => array(
					'text'         => __( 'Font color', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
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
				'value_path'     => array( 'font_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--brandy-text-color',
							'value_path' => array( 'font_color' ),
						),
					),
				),
			),
			'links_decoration'     => array(
				'title'          => array(
					'text' => __( 'Links decoration', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'ButtonGroup',
				'default_value'  => 'inherit',
				'options'        => array(
					array(
						'value' => 'normal',
						'label' => __( 'Normal', 'brandy' ),
					),
					array(
						'value' => 'inherit',
						'label' => __( 'Inherit', 'brandy' ),
					),
					array(
						'value' => 'underline',
						'label' => __( 'Underline', 'brandy' ),
					),
				),
				'value_path'     => array( 'links_decoration' ),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-widget-content',
							'name'       => 'links-decoration',
							'value_path' => array( 'links_decoration' ),
						),
					),
				),
			),
			'margin'               => array(
				'title'          => array(
					'text' => __( 'Margin', 'brandy' ),
					'type' => 'bold',
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
							'name'       => '--brandy-margin',
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
						'components' => array( 'content' ),
					),
					array(
						'components' => array( 'horizontal_alignment' ),
					),
					array(
						'components' => array( 'vertical_alignment' ),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array( 'font_color' ),
					),
					array(
						'components' => array( 'links_decoration' ),
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

}
