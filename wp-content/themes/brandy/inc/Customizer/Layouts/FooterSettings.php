<?php

namespace Brandy\Customizer\Layouts;

use Brandy\Abstracts\AbstractLayout;
use Brandy\Builder\Footer\FooterBuilder;
use Brandy\Traits\SingletonTrait;

class FooterSettings extends AbstractLayout {

	use SingletonTrait;

	protected $components = array();

	protected $section_id = 'footer';

	public function add_layout( $layouts = array() ) {
		$layout                       = array(
			'general' => array(
				'sections' => array(
					array(
						'components' => array( 'footer_name' ),
					),
					array(
						'components' => array( 'layout' ),
					),
					array(
						'components' => array( 'background' ),
					),
					array(
						'components' => array( 'transparent', 'disabled_pages' ),
					),
					array(
						'components' => array( 'padding' ),
					),
				),
			),
			'designs' => array(
				'sections' => array(),
			),
		);
		$mapped_layout                = $this->map_layout( $layout );
		$layouts[ $this->section_id ] = $mapped_layout;
		return $layouts;
	}

	protected function register_components() {
		return array(
			'footer_name'    => array(
				'title'         => array(
					'text' => __( 'Footer name', 'brandy' ),
					'type' => 'bold',
				),
				'type'          => 'TextInput',
				'value_path'    => array( 'name' ),
				'default_value' => '',
			),
			'background'     => array(
				'value_path'     => array( 'background' ),
				'title'          => array(
					'text' => __( 'Background', 'brandy' ),
					'type' => 'bold',
				),
				'default_value'  => array(
					'type'           => 'solid',
					'solid_color'    => '#ffffff00',
					'gradient_color' => 'linear-gradient(90deg, RGBA(27, 60, 221, 1) 0%, rgba(251,208,238,1) 100%)',
					'image'          => array(
						'url'           => '',
						'top'           => array(
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 100,
							'value' => 0,
						),
						'left'          => array(
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 100,
							'value' => 0,
						),
						'overlay_color' => '#fff',
						'size'          => 'auto',
						'position'      => 'left',
					),
				),
				'type'           => 'Background',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'background',
							'name'       => '--brandy-footer-background',
							'value_path' => array( 'background' ),
						),
					),
				),
			),
			'layout'         => array(
				'title'          => array(
					'text' => __( 'Layout', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'layout' ),
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'label' => __( 'Boxed', 'brandy' ),
						'value' => 'builder-boxed',
					),
					array(
						'label' => __( 'Content', 'brandy' ),
						'value' => 'site-contented',
					),
					array(
						'label' => __( 'Full width', 'brandy' ),
						'value' => 'full-width',
					),
				),
				'default_value'  => 'full_width',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'      => '.brandy-child-footer .footer-container',
							'name'          => 'class',
							'value_path'    => array( 'layout' ),
							'default_class' => 'footer-container',
						),
						array(
							'selector'   => '.brandy-child-footer',
							'name'       => 'data-layout',
							'value_path' => array( 'layout' ),
						),
					),
				),
			),
			'transparent'    => array(
				'title'          => array(
					'text' => __( 'Transparent', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'value_path'     => array( 'transparent', 'enabled' ),
				'default_value'  => false,
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'disabled_pages' => array(
				'title'          => array(
					'text' => __( 'Disable Transparent On', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'multiple_dropdown',
				'value_path'     => array( 'transparent', 'disabled_pages' ),
				'default_value'  => array(),
				'options'        => array(
					array(
						'label' => __( 'Disable on 404, Search & Archives?', 'brandy' ),
						'value' => 'disable_on_404',
					),
					array(
						'label' => __( 'Disable on Blog page?', 'brandy' ),
						'value' => 'disable_on_blog',
					),
					array(
						'label' => __( 'Disable on Latest Post page?', 'brandy' ),
						'value' => 'disable_on_latest_post',
					),
					array(
						'label' => __( 'Disable on Pages?', 'brandy' ),
						'value' => 'disable_on_pages',
					),
					array(
						'label' => __( 'Disable on Posts?', 'brandy' ),
						'value' => 'disable_on_posts',
					),
				),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'padding'        => array(
				'value_path'     => array( 'padding' ),
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => '--brandy-footer-padding',
							'value_path' => array( 'padding' ),
						),
					),
				),
			),
		);
	}

	public function add_partial_refresh( $partials = array() ) {
		$partials[] = array(
			'configuration_type' => 'control',
			'id'                 => 'footer',
			'partial'            => array(
				'selector'            => '#brandy-footer',
				'render_callback'     => array( FooterBuilder::get_instance(), 'render_footer' ),
				'container_inclusive' => true,
				'fallback_refresh'    => true,
			),
			'default'            => '',
			'transport'          => 'postMessage',
		);
		return $partials;
	}
}
