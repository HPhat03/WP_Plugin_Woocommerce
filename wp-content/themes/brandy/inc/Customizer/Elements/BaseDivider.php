<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;

class BaseDivider extends AbstractBaseElement {

	protected $element_id = 'divider';

	protected $title = 'Divider';

	protected $builders = array( 'header', 'footer' );

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
			  d="M5.75 5C5.33579 5 5 5.33579 5 5.75C5 6.16421 5.33579 6.5 5.75 6.5H24.2511C24.6653 6.5 25.0011 6.16421 25.0011 5.75C25.0011 5.33579 24.6653 5 24.2511 5H5.75ZM5.75 23.4989C5.33579 23.4989 5 23.8346 5 24.2489C5 24.6631 5.33579 24.9989 5.75 24.9989H24.2511C24.6653 24.9989 25.0011 24.6631 25.0011 24.2489C25.0011 23.8346 24.6653 23.4989 24.2511 23.4989H5.75ZM5.85706 14.123C5.58091 14.123 5.35706 14.3469 5.35706 14.623C5.35706 14.8992 5.58091 15.123 5.85706 15.123H7.35706C7.6332 15.123 7.85706 14.8992 7.85706 14.623C7.85706 14.3469 7.6332 14.123 7.35706 14.123H5.85706ZM10.3571 14.123C10.0809 14.123 9.85706 14.3469 9.85706 14.623C9.85706 14.8992 10.0809 15.123 10.3571 15.123H13.3571C13.6332 15.123 13.8571 14.8992 13.8571 14.623C13.8571 14.3469 13.6332 14.123 13.3571 14.123H10.3571ZM16.3571 14.123C16.0809 14.123 15.8571 14.3469 15.8571 14.623C15.8571 14.8992 16.0809 15.123 16.3571 15.123H19.3571C19.6332 15.123 19.8571 14.8992 19.8571 14.623C19.8571 14.3469 19.6332 14.123 19.3571 14.123H16.3571ZM22.3571 14.123C22.0809 14.123 21.8571 14.3469 21.8571 14.623C21.8571 14.8992 22.0809 15.123 22.3571 15.123H23.8571C24.1332 15.123 24.3571 14.8992 24.3571 14.623C24.3571 14.3469 24.1332 14.123 23.8571 14.123H22.3571ZM15.4048 8.92659C15.3108 8.79724 15.1604 8.7207 15.0005 8.7207C14.8405 8.7207 14.6902 8.79724 14.5961 8.92659L12.9142 11.239C12.7518 11.4623 12.8011 11.775 13.0245 11.9374C13.2478 12.0998 13.5605 12.0505 13.7229 11.8272L14.5005 10.7582V19.2429L13.7229 18.1738C13.5604 17.9505 13.2477 17.9011 13.0244 18.0635C12.8011 18.226 12.7517 18.5387 12.9142 18.762L14.5881 21.0635C14.6783 21.1946 14.8293 21.2806 15.0005 21.2806C15.1727 21.2806 15.3247 21.1935 15.4146 21.0609L17.0867 18.762C17.2491 18.5387 17.1998 18.226 16.9765 18.0635C16.7531 17.9011 16.4404 17.9505 16.278 18.1738L15.5005 19.2427V10.7581L16.2781 11.8272C16.4405 12.0505 16.7532 12.0998 16.9765 11.9374C17.1998 11.775 17.2492 11.4623 17.0868 11.239L15.4048 8.92659Z"
			  fill="' . BRANDY_ICON_COLOR_NORMAL . '"
			/>
		  </svg>';

	public function template_path() {
		return 'template-parts/builder/elements/divider';
	}

	protected function register_components() {
		return array(
			'layout'            => array(
				'title'          => array(
					'text'         => __( 'Layout', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'label' => __( 'Horizontal', 'brandy' ),
						'value' => 'horizontal',
					),
					array(
						'label' => __( 'Vertical', 'brandy' ),
						'value' => 'vertical',
					),
				),
				'default_value'  => array(
					'desktop' => 'vertical',
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'layout' ),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-divider',
							'name'       => 'data-desktop-layout',
							'value_path' => array( 'layout', 'desktop' ),
						),
						array(
							'selector'   => '.brandy-divider',
							'name'       => 'data-tablet-layout',
							'value_path' => array( 'layout', 'tablet' ),
						),
						array(
							'selector'   => '.brandy-divider',
							'name'       => 'data-mobile-layout',
							'value_path' => array( 'layout', 'mobile' ),
						),
					),
				),
			),
			'vertical_height'   => array(
				'title'              => array(
					'text'         => __( 'Height (px)', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'               => 'Dimension',
				'units'              => array( 'px', '%' ),
				'default_value'      => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 70,
						'min'   => 1,
						'max'   => 1000,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'         => array( 'vertical_height' ),
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-vertical-height',
							'value_path' => array( 'vertical_height' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path'   => array( 'layout' ),
						'value'        => 'vertical',
						'match_device' => true,
					),
				),
			),
			'vertical_width'    => array(
				'title'              => array(
					'text'         => __( 'Width', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'               => 'Dimension',
				'units'              => array( 'px' ),
				'default_value'      => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 1,
						'min'   => 1,
						'max'   => 10,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'         => array( 'vertical_width' ),
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-vertical-width',
							'value_path' => array( 'vertical_width' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path'   => array( 'layout' ),
						'value'        => 'vertical',
						'match_device' => true,
					),
				),
			),
			'horizontal_height' => array(
				'title'              => array(
					'text'         => __( 'Height (px)', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'               => 'Dimension',
				'units'              => array( 'px' ),
				'default_value'      => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 1,
						'min'   => 1,
						'max'   => 10,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'         => array( 'horizontal_height' ),
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-divider',
							'name'       => '--b-horizontal-height',
							'value_path' => array( 'horizontal_height' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path'   => array( 'layout' ),
						'value'        => 'horizontal',
						'match_device' => true,
					),
				),
			),
			'horizontal_width'  => array(
				'title'              => array(
					'text'         => __( 'Width', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'               => 'Dimension',
				'units'              => array( 'px', '%' ),
				'default_value'      => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 100,
						'min'   => 1,
						'max'   => 1000,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'         => array( 'horizontal_width' ),
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-horizontal-width',
							'value_path' => array( 'horizontal_width' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path'   => array( 'layout' ),
						'value'        => 'horizontal',
						'match_device' => true,
					),
				),
			),
			'color'             => array(
				'title'          => array(
					'text' => __( 'Color', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => 'var(--wp--preset--color--brandy-border)',
				),
				'value_path'     => array( 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-color',
							'selector'   => '.brandy-divider',
							'value_path' => array( 'color' ),
						),
					),
				),
			),
			'padding'           => array(
				'value_path'     => array( 'padding' ),
				'title'          => array(
					'text' => 'Padding',
					'type' => 'bold',
				),
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'unit'           => 'px',
					'top'            => 10,
					'right'          => 10,
					'bottom'         => 10,
					'left'           => 10,
					'is_constraints' => false,
				),
				'type'           => array( 'Spacing' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => 'padding',
							'selector'   => '.brandy-divider',
							'value_path' => array( 'padding' ),
						),
					),
				),
			),
			'margin'            => array(
				'value_path'     => array( 'margin' ),
				'title'          => array(
					'text'         => 'Margin',
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
							'selector'   => '.brandy-divider',
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
						'components' => array( 'layout' ),
					),
					array(
						'components' => array( 'vertical_height', 'horizontal_height' ),
					),
					array(
						'components' => array( 'vertical_width', 'horizontal_width' ),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array( 'color' ),
					),
					array(
						'components' => array( 'padding' ),
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
