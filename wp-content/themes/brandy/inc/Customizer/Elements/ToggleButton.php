<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\TypographyService;
use Brandy\Traits\SingletonTrait;

class ToggleButton extends AbstractBaseElement {

	use SingletonTrait;

	protected $element_id = 'toggle_button';

	public static $path_to_icons = BRANDY_TEMPLATE_DIR . '/template-parts/icons/togglebutton/';

	protected $title = 'Toggle Button';

	protected $icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M5 8C5 7.44772 5.44772 7 6 7H15C15.5523 7 16 7.44772 16 8C16 8.55228 15.5523 9 15 9H6C5.44772 9 5 8.55228 5 8ZM5 15C5 14.4477 5.44772 14 6 14L24 14C24.5523 14 25 14.4477 25 15C25 15.5523 24.5523 16 24 16L6 16C5.44772 16 5 15.5523 5 15ZM15 21C14.4477 21 14 21.4477 14 22C14 22.5523 14.4477 23 15 23H24C24.5523 23 25 22.5523 25 22C25 21.4477 24.5523 21 24 21H15Z" fill="' . BRANDY_ICON_COLOR_NORMAL . '"/>
			</svg>
			';

	protected function register_components() {

		$button_types = array( 'type_1', 'type_2', 'type_3', 'type_4' );
		$options      = array_map(
			function( $type ) {
				return array(
					'value' => $type,
					'label' => self::get_icon( $type ),
				);
			},
			$button_types
		);
		return array(
			'button_type'           => array(
				'title'          => array(
					'text' => __( 'Toggle button type', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'IconGroup',
				'value_path'     => array( 'button_type' ),
				'default_value'  => 'type_3',
				'options'        => $options,
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'text_enabled'          => array(
				'title'          => array(
					'text' => __( 'Button text', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'value_path'     => array( 'text', 'enabled' ),
				'default_value'  => false,
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'text_input'            => array(
				'type'               => 'TextInput',
				'value_path'         => array( 'text', 'value' ),
				'default_value'      => 'MENU',
				'render_options'     => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-toggle-button__text',
							'value_path' => array( 'text', 'value' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'text', 'enabled' ),
						'value'      => true,
					),
				),
			),
			'text_position'         => array(
				'type'               => 'ButtonGroup',
				'title'              => array(
					'text' => __( 'Text position', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( 'text', 'position' ),
				'default_value'      => 'right',
				'options'            => array(
					array(
						'label' => __( 'Left', 'brandy' ),
						'value' => 'left',
					),
					array(
						'label' => __( 'Right', 'brandy' ),
						'value' => 'right',
					),
				),
				'render_options'     => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-toggle-button__text',
							'name'       => 'data-position',
							'value_path' => array( 'text', 'position' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'text', 'enabled' ),
						'value'      => true,
					),
				),
			),
			'icon_reset'            => array(
				'title'       => array(
					'text'         => __( 'Icon button', 'brandy' ),
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
					'text' => __( 'Color', 'brandy' ),
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
							'name'       => '--b-icon-color',
							'value_path' => array( 'icon', 'color' ),
						),
					),
				),
			),
			'icon_background_color' => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'icon', 'background' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#ffff',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#ffff',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-icon-background',
							'value_path' => array( 'icon', 'background' ),
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
						'desktop' => '#ffff',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#ffff',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-icon-stroke-color',
							'value_path' => array( 'icon', 'stroke', 'color' ),
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
						'value' => 0,
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
							'name'       => '--b-icon-stroke-width',
							'value_path' => array( 'icon', 'stroke', 'width' ),
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
						'value' => 3,
						'min'   => 0,
						'max'   => 100,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-icon-border-radius',
							'value_path' => array( 'icon', 'border_radius' ),
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
							'name'       => '--b-icon-size',
							'value_path' => array( 'icon', 'size' ),
						),
					),
				),
			),
			'text_reset'            => array(
				'title'       => array(
					'text'         => __( 'Button text', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'text', 'style' ),
				),
			),
			'text_color'            => array(
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'text', 'style', 'color' ),
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
							'name'       => '--b-text-color',
							'value_path' => array( 'text', 'style', 'color' ),
						),
					),
				),
			),
			'text_typography'       => array(
				'title'          => array(
					'text' => __( 'Typography', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'text', 'style', 'typography' ),
				'type'           => 'Typography',
				'default_value'  => null,
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-toggle-button__text',
							'value_path' => array( 'text', 'style', 'typography' ),
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
				'value_path'     => array( 'margin' ),
				'type'           => 'Spacing',
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
						'components' => array(
							'button_type',
						),
					),
					array(
						'components' => array(
							'text_enabled',
							'text_input',
							'text_position',
						),
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
						'components'         => array(
							'text_reset',
							'text_color',
							'text_typography',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'text', 'enabled' ),
								'value'      => true,
							),
						),
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

}
