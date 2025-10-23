<?php
/**
 * Input Settings Section class
 *
 * @package Brandy\Customizer
 * @since   1.0.0
 */

namespace Brandy\Customizer\Panels\General;

use Brandy\Abstracts\AbstractCustomizerModuleLoader;
use Brandy\Core\Services\InputService;
use Brandy\Traits\SingletonTrait;

class InputSettingsSection extends AbstractCustomizerModuleLoader {

	use SingletonTrait;

	public const SECTION_ID = 'input_settings';

	protected function __construct() {
		add_filter(
			'brandy_general_sections',
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
			'brandy_general_default_settings',
			function( $settings ) {
				$settings[ self::SECTION_ID ] = InputService::get_default_settings();
				return $settings;
			}
		);
		parent::__construct();
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
			'title'              => __( 'Input Settings', 'brandy' ),
			'panel'              => GeneralPanel::PANEL_ID,
			'type'               => 'brandy-section',
			'description_hidden' => true,
		);
		$configurations[] = array(
			'configuration_type' => 'control',
			'id'                 => self::SECTION_ID,
			'label'              => __( 'Input Settings', 'brandy' ),
			'section'            => self::SECTION_ID,
			'type'               => 'brandy_settings',
			'input_attrs'        => array(
				'value' => '',
				'style' => 'display:none;',
			),
			'partial'            => false,
			'default'            => InputService::get_default_settings(),
			'transport'          => 'postMessage',
		);

		return $configurations;
	}

	public function print_global_css() {
		InputService::print_css();
	}

}
