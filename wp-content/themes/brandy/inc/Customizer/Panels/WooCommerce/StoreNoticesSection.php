<?php
/**
 * The Store Notice Section class is responsible for loading and
 * registering the customizer settings and controls for the Header Builder module.
 *
 * @package Brandy\Customizer
 * @since   1.0.0
 */

namespace Brandy\Customizer\Panels\WooCommerce;

use Brandy\Abstracts\AbstractCustomizerModuleLoader;
use Brandy\Traits\SingletonTrait;
use Brandy\Utils\StylesDataHelpers;

/**
 * Register Header stuffs
 * Header panel and section are registered here
 */
class StoreNoticesSection extends AbstractCustomizerModuleLoader {

	use SingletonTrait;

	public const SECTION_ID = 'wc_store_notices';

	protected function __construct() {
		add_filter(
			'brandy_wc_sections',
			function( $sections ) {
				return array_merge(
					$sections,
					array_filter(
						self::get_configurations(),
						function( $item ) {
							return 'section' === $item['configuration_type'];
						}
					)
				);
			}
		);
		add_filter(
			'brandy_wc_default_settings',
			function( $settings ) {
				$settings[ self::SECTION_ID ] = self::get_default_value();
				return $settings;
			}
		);
		parent::__construct();
	}

	/**
	 * Returns module configurations
	 * Because this is the main loader, so return panel configurations
	 *
	 * @override
	 */
	public static function get_configurations() {
		$configurations[] = array(
			'configuration_type' => 'section',
			'id'                 => self::SECTION_ID,
			'title'              => __( 'Store Notices', 'brandy' ),
			'panel'              => WooCommercePanel::PANEL_ID,
			'type'               => 'brandy-section',
			'description_hidden' => true,
		);
		$configurations[] = array(
			'configuration_type' => 'control',
			'id'                 => self::SECTION_ID,
			'label'              => __( 'Store Notices', 'brandy' ),
			'section'            => self::SECTION_ID,
			'type'               => 'brandy_settings',
			'input_attrs'        => array(
				'value' => '',
				'style' => 'display:none;',
			),
			'partial'            => false,
			'default'            => self::get_default_value(),
			'transport'          => 'postMessage',
		);

		return $configurations;
	}

	public static function get_default_value() {
		return array(
			'information' => array(
				'text_color'      => array(
					'normal' => 'var(--wp--preset--color--brandy-secondary-text)',
					'hover'  => 'var(--wp--preset--color--brandy-gray-9)',
				),
				'background'      => array(
					'normal' => 'var(--wp--preset--color--brandy-border)',
				),
				'border'          => array(
					'color' => array(
						'normal' => 'var(--wp--preset--color--brandy-gray-4)',
					),
					'width' => array(
						'value' => 0,
						'min'   => 0,
						'max'   => 10,
						'unit'  => 'px',
					),
				),
			),
			'success'     => array(
				'text_color'      => array(
					'normal' => '#4ab866',
					'hover'  => '#4ab866',
				),
				'background'      => array(
					'normal' => '#f4fff7',
				),
				'border'          => array(
					'color' => array(
						'normal' => '#4ab866',
					),
					'width' => array(
						'value' => 0,
						'min'   => 0,
						'max'   => 10,
						'unit'  => 'px',
					),
				),
			),
			'error'       => array(
				'text_color'      => array(
					'normal' => '#cc1818',
					'hover'  => '#cc1818',
				),
				'background'      => array(
					'normal' => '#fff0f0',
				),
				'border'          => array(
					'color' => array(
						'normal' => '#cc1818',
					),
					'width' => array(
						'value' => 0,
						'min'   => 0,
						'max'   => 10,
						'unit'  => 'px',
					),
				),
			),
		);
	}

	public static function print_dynamic_css() {
		$settings  = get_theme_mod( self::SECTION_ID );
		$settings  = empty( $settings ) ? self::get_default_value() : $settings;
		$css       = '';
		$variables = array();
		foreach ( $settings as $section => $data ) {
			$variables[] = "--wc-$section-text_color-normal:" . $data['text_color']['normal'];
			$variables[] = "--wc-$section-text_color-hover:" . $data['text_color']['hover'];
			$variables[] = "--wc-$section-background-normal:" . $data['background']['normal'];
			$variables[] = "--wc-$section-border-color-normal:" . $data['border']['color']['normal'];
			$variables[] = "--wc-$section-border-width:" . StylesDataHelpers::get_dimension_css( $data['border']['width'] );
		}

		$css .= 'body{' . implode( ';', $variables ) . '}';
		echo wp_kses_post( $css );
	}

}
