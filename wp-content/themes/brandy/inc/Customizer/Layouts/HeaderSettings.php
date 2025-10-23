<?php

namespace Brandy\Customizer\Layouts;

use Brandy\Abstracts\AbstractLayout;
use Brandy\Builder\Header\HeaderBuilder;
use Brandy\Traits\SingletonTrait;

class HeaderSettings extends AbstractLayout {

	use SingletonTrait;

	protected $components = array();

	protected $section_id = 'header';

	public function add_layout( $layouts = array() ) {
		$layout                       = array(
			'general' => array(
				'sections' => array(
					array(
						'components' => array( 'header_name' ),
					),
					array(
						'components' => array( 'layout' ),
					),
					array(
						'components' => array( 'sticky_functionality_enabled', 'sticky_on', 'sticky_effect', 'only_show_when_scrolling_up' ),
					),
					array(
						'components' => array( 'transparent', 'disabled_pages', 'blur_background', 'transparent_background', 'sticky_background' ),
					),
					array(
						'components' => array( 'box_shadow' ),
					),
					array(
						'components' => array( 'sticky_box_shadow' ),
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
			'header_name'                  => array(
				'title'         => array(
					'text' => __( 'Header name', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'    => array( 'name' ),
				'type'          => 'TextInput',
				'default_value' => '',
			),
			'layout'                       => array(
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
							'selector'      => '.brandy-child-header .header-container',
							'name'          => 'class',
							'value_path'    => array( 'layout' ),
							'default_class' => 'header-container',
						),
						array(
							'selector'   => '.brandy-child-header',
							'name'       => 'data-layout',
							'value_path' => array( 'layout' ),
						),
					),
				),
			),
			'sticky_functionality_enabled' => array(
				'title'          => array(
					'text'         => __( 'Sticky functionality', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'           => 'Switcher',
				'value_path'     => array( 'sticky_functionality', 'enabled' ),
				'default_value'  => array(
					'desktop' => true,
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'sticky_on'                    => array(
				'title'          => array(
					'text' => __( 'Sticky on', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dropdown',
				'default_value'  => array(
					'desktop' => 'top',
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'sticky_functionality', 'sticky_on' ),
				'options'        => array(
					array(
						'label' => __( 'Only main row', 'brandy' ),
						'value' => 'middle',
					),
					array(
						'label' => __( 'Top & main row', 'brandy' ),
						'value' => 'top,middle',
					),
					array(
						'label' => __( 'All rows', 'brandy' ),
						'value' => 'top,middle,bottom',
					),
					array(
						'label' => __( 'Main & bottom row', 'brandy' ),
						'value' => 'middle,bottom',
					),
					array(
						'label' => __( 'Only top row', 'brandy' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Only bottom row', 'brandy' ),
						'value' => 'bottom',
					),
				),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'sticky_effect'                => array(
				'title'          => array(
					'text' => __( 'Effect', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dropdown',
				'default_value'  => array(
					'desktop' => 'slide_down',
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'sticky_functionality', 'sticky_effect' ),
				'options'        => array(
					array(
						'label' => __( 'Default', 'brandy' ),
						'value' => 'default',
					),
					array(
						'label' => __( 'Slide down', 'brandy' ),
						'value' => 'slide_down',
					),
					array(
						'label' => __( 'Fade', 'brandy' ),
						'value' => 'fade_in',
					),
				),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '[device="desktop"] .sticky-part',
							'name'       => 'effect',
							'value_path' => array( 'sticky_functionality', 'sticky_effect', 'desktop' ),
						),
						array(
							'selector'   => '[device="mobile"] .sticky-part',
							'name'       => 'effect',
							'value_path' => array( 'sticky_functionality', 'sticky_effect', 'tablet' ),
						),
					),
				),
			),
			'only_show_when_scrolling_up'  => array(
				'title'          => array(
					'text' => __( 'Only show when scrolling up', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Switcher',
				'value_path'     => array( 'sticky_functionality', 'only_show_when_scrolling_up' ),
				'default_value'  => array(
					'desktop' => true,
					'mobile'  => null,
					'tablet'  => null,
				),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'       => '[device="desktop"] .sticky-part',
							'name'           => 'data-only-show-when-scrolling-up',
							'type'           => 'switcher',
							'value_path'     => array( 'sticky_functionality', 'only_show_when_scrolling_up', 'desktop' ),
							'enabled_value'  => 'true',
							'disabled_value' => 'false',
						),
						array(
							'selector'       => '[device="mobile"] .sticky-part',
							'name'           => 'data-only-show-when-scrolling-up',
							'type'           => 'switcher',
							'value_path'     => array( 'sticky_functionality', 'only_show_when_scrolling_up', 'tablet' ),
							'enabled_value'  => 'true',
							'disabled_value' => 'false',
						),
					),
				),
			),
			'transparent'                  => array(
				'title'          => array(
					'text' => __( 'Transparent', 'brandy' ),
					'type' => 'bold',
				),
				'description'    => __( 'All below transparent settings will only affect when Transparent is enabled', 'brandy' ),
				'type'           => 'Switcher',
				'value_path'     => array( 'transparent', 'enabled' ),
				'default_value'  => false,
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'box_shadow'                   => array(
				'title'          => array(
					'text' => __( 'Shadow', 'brandy' ),
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
				'value_path'     => array( 'box_shadow' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'box_shadow',
							'name'       => '--brandy-header-box-shadow',
							'value_path' => array( 'box_shadow' ),
						),
					),
				),
			),
			'sticky_box_shadow'            => array(
				'title'          => array(
					'text' => __( 'Shadow when sticky', 'brandy' ),
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
				'value_path'     => array( 'sticky_box_shadow' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'box_shadow',
							'name'       => '--brandy-header-sticky-box-shadow',
							'value_path' => array( 'sticky_box_shadow' ),
						),
					),
				),
			),
			'disabled_pages'               => array(
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
			'sticky_background'            => array(
				'title'          => array(
					'text' => __( 'Sticky background', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'transparent', 'sticky_background' ),
				'default_value'  => array(
					'top'    => '#ffffff',
					'middle' => '#ffffff',
					'bottom' => '#ffffff',
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'name'       => '--brandy-top-header-sticky-background',
							'value_path' => array( 'transparent', 'sticky_background', 'top' ),
						),
						array(
							'name'       => '--brandy-middle-header-sticky-background',
							'value_path' => array( 'transparent', 'sticky_background', 'middle' ),
						),
						array(
							'name'       => '--brandy-bottom-header-sticky-background',
							'value_path' => array( 'transparent', 'sticky_background', 'bottom' ),
						),
					),
				),
			),
			'blur_background'              => array(
				'title'          => array(
					'text' => __( 'Blur background', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'transparent', 'blur_background' ),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'unit'  => 'px',
					'value' => 0,
					'min'   => 0,
					'max'   => 30,
				),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--brandy-header-sticky-blur-value',
							'value_path' => array( 'transparent', 'blur_background' ),
						),
					),
				),
			),
			'transparent_background'       => array(
				'title'          => array(
					'text' => __( 'Transparent background', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'transparent', 'transparent_background' ),
				'default_value'  => array(
					'top'    => '#ffffff00',
					'middle' => '#ffffff00',
					'bottom' => '#ffffff00',
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'name'       => '--brandy-top-header-transparent-background',
							'value_path' => array( 'transparent', 'transparent_background', 'top' ),
						),
						array(
							'name'       => '--brandy-middle-header-transparent-background',
							'value_path' => array( 'transparent', 'transparent_background', 'middle' ),
						),
						array(
							'name'       => '--brandy-bottom-header-transparent-background',
							'value_path' => array( 'transparent', 'transparent_background', 'bottom' ),
						),
					),
				),
			),
		);
	}

	public function add_partial_refresh( $partials = array() ) {
		$partials[] = array(
			'configuration_type' => 'control',
			'id'                 => 'header',
			'partial'            => array(
				'selector'            => '#brandy-header',
				'render_callback'     => array( HeaderBuilder::get_instance(), 'render_header' ),
				'container_inclusive' => true,
				'fallback_refresh'    => true,
			),
			'default'            => '',
			'transport'          => 'postMessage',
		);
		return $partials;
	}
}
