<?php
/**
 * The WooCommerce Panel class is responsible for loading and
 * registering the customizer settings and controls for the Header Builder module.
 *
 * @package Brandy\Customizer
 * @since   1.0.0
 */

namespace Brandy\Customizer\Panels\WooCommerce;

use Brandy\Abstracts\AbstractCustomizerModuleLoader;
use Brandy\Traits\SingletonTrait;

/**
 * Register Header stuffs
 * Header panel and section are registered here
 */
class WooCommercePanel extends AbstractCustomizerModuleLoader {

	use SingletonTrait;

	public const PANEL_ID = 'woocommerce-settings';

	protected function __construct() {

		if ( ! function_exists( 'is_wc_installed' ) || ! is_wc_installed() ) {
			return;
		}

		add_action( 'customize_register', array( $this, 'remove_default_woocommerce_customizer' ) );

		parent::__construct();

		$this->register_sections();

		add_action( 'brandy_print_global_css', array( $this, 'print_global_css' ) );
		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );
		add_filter( 'brandy_customizer_extra_panels', array( $this, 'register_extra_panels' ) );
	}

	private function register_sections() {
		StoreNoticesSection::get_instance();
		ProductCatalogSection::get_instance();
		Checkout::get_instance();
	}

	public function register_extra_panels( $panels ) {
		$panels[] = array(
			'id'    => self::PANEL_ID,
			'title' => __( 'WooCommerce', 'brandy' ),
		);
		return $panels;
	}

	public function remove_default_woocommerce_customizer( $wp_customize ) {
		$wp_customize->remove_panel( 'woocommerce' );
	}

	/**
	 * Returns module configurations
	 * Because this is the main loader, so return panel configurations
	 *
	 * @override
	 */
	public static function get_configurations() {
		$configurations = array(
			array(
				'configuration_type' => 'panel',
				'id'                 => self::PANEL_ID,
				'title'              => __( 'WooCommerce', 'brandy' ),
				'description'        => '',
				'priority'           => 10,
				'type'               => 'brandy_panel',
			),
		);

		return $configurations;
	}

	public static function print_global_css() {
		if ( ! function_exists( 'is_wc_installed' ) || ! is_wc_installed() ) {
			return;
		}
		?>
		<style id="brandy-wc-css">
			<?php
			StoreNoticesSection::print_dynamic_css();
			ProductCatalogSection::print_dynamic_css();
			?>
		</style>
		<?php
	}

	public function add_localize_data( $data ) {
		$data['woocommerce'] = array(
			'sections'         => apply_filters( 'brandy_wc_sections', array() ),
			'default_settings' => apply_filters( 'brandy_wc_default_settings', array() ),
		);
		return $data;
	}

}
