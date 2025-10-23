<?php
/**
 * The General Panel class is responsible for loading and
 * registering the customizer settings and controls for the Header Builder module.
 *
 * @package Brandy\Customizer
 * @since   1.0.0
 */

namespace Brandy\Customizer\Panels\General;

use Brandy\Abstracts\AbstractCustomizerModuleLoader;
use Brandy\Traits\SingletonTrait;

/**
 * Register Header stuffs
 * Header panel and section are registered here
 */
class GeneralPanel extends AbstractCustomizerModuleLoader {

	use SingletonTrait;

	public const PANEL_ID = 'general-settings';

	protected function __construct() {

		parent::__construct();

		$this->register_sections();
		add_action( 'brandy_print_global_css', array( $this, 'print_general_css' ) );
		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );
		add_filter( 'brandy_customizer_extra_panels', array( $this, 'register_extra_panels' ) );
	}

	private function register_sections() {
		ButtonSettingsSection::get_instance();
		InputSettingsSection::get_instance();
		SelectSettingsSection::get_instance();
	}

	public function register_extra_panels( $panels ) {
		$panels[] = array(
			'id'    => self::PANEL_ID,
			'title' => __( 'General', 'brandy' ),
		);
		return $panels;
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
				'title'              => __( 'General', 'brandy' ),
				'description'        => '',
				'priority'           => 10,
				'type'               => 'brandy_panel',
			),
		);

		return $configurations;
	}

	public function print_general_css() { ?>
		<style id="brandy-general-variables">
		<?php
		do_action( 'brandy_global_css_general_variables' );
		?>
		</style>
		<?php
	}

	public function add_localize_data( $data ) {
		$data['general'] = array(
			'sections'         => apply_filters( 'brandy_general_sections', array() ),
			'default_settings' => apply_filters( 'brandy_general_default_settings', array() ),
		);
		return $data;
	}

}
