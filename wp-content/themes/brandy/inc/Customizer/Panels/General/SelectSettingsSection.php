<?php
/**
 * Select Settings Section class
 *
 * @package Brandy\Customizer
 * @since   1.0.0
 */

namespace Brandy\Customizer\Panels\General;

use Brandy\Abstracts\AbstractCustomizerModuleLoader;
use Brandy\Core\Services\SelectService;
use Brandy\Traits\SingletonTrait;

class SelectSettingsSection extends AbstractCustomizerModuleLoader {

	use SingletonTrait;

	public const SECTION_ID = 'select_settings';

	protected function __construct() {
		add_action( 'brandy_global_css_general_variables', array( $this, 'print_global_css' ) );
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
			'title'              => __( 'Select Settings', 'brandy' ),
			'panel'              => GeneralPanel::PANEL_ID,
			'type'               => 'brandy-section',
			'description_hidden' => true,
		);
		$configurations[] = array(
			'configuration_type' => 'control',
			'id'                 => self::SECTION_ID,
			'label'              => __( 'Select Settings', 'brandy' ),
			'section'            => self::SECTION_ID,
			'type'               => 'brandy_settings',
			'input_attrs'        => array(
				'value' => '',
				'style' => 'display:none;',
			),
			'partial'            => false,
			'default'            => SelectService::get_default_settings(),
			'transport'          => 'postMessage',
		);

		return $configurations;
	}

	public function print_global_css() {
		SelectService::print_css();
	}

}
