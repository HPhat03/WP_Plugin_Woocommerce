<?php
/**
 * The Product Catalog Section class is responsible for loading and
 * registering the customizer settings and controls for the Header Builder module.
 *
 * @package Brandy\Customizer
 * @since   1.0.0
 */

namespace Brandy\Customizer\Panels\WooCommerce;

use Brandy\Abstracts\AbstractCustomizerModuleLoader;
use Brandy\Core\Services\ProductCatalogService;
use Brandy\Traits\SingletonTrait;

/**
 * Register Header stuffs
 * Header panel and section are registered here
 */
class ProductCatalogSection extends AbstractCustomizerModuleLoader {

	use SingletonTrait;

	public const SECTION_ID = 'wc_product_catalog';

	protected function __construct() {
		// add_filter(
		// 	'brandy_wc_sections',
		// 	function( $sections ) {
		// 		return array_merge(
		// 			$sections,
		// 			array_filter(
		// 				self::get_configurations(),
		// 				function( $item ) {
		// 					return 'section' === $item['configuration_type'];
		// 				}
		// 			)
		// 		);
		// 	}
		// );
		// add_filter(
		// 	'brandy_wc_default_settings',
		// 	function( $settings ) {
		// 		$settings[ self::SECTION_ID ] = ProductCatalogService::get_default_settings();
		// 		return $settings;
		// 	}
		// );

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
			'title'              => __( 'Product Catalog', 'brandy' ),
			'panel'              => WooCommercePanel::PANEL_ID,
			'type'               => 'brandy-section',
			'description_hidden' => true,
		);
		$configurations[] = array(
			'configuration_type' => 'control',
			'id'                 => self::SECTION_ID,
			'label'              => __( 'Product Catalog', 'brandy' ),
			'section'            => self::SECTION_ID,
			'type'               => 'brandy_settings',
			'input_attrs'        => array(
				'value' => '',
				'style' => 'display:none;',
			),
			'partial'            => false,
			'default'            => ProductCatalogService::get_default_settings(),
			'transport'          => 'postMessage',
		);

		return $configurations;
	}

	public static function print_dynamic_css() {
	}

}
