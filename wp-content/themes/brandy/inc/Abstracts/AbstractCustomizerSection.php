<?php
/**
 * The AbstractCustomizerSection abstract class is responsible for loading and
 * registering the customizer settings and controls for a Section module
 *
 * @package Brandy\Customizer
 * @since 1.0.0
 */

namespace Brandy\Abstracts;

/**
 * Declare abstract class
 */
abstract class AbstractCustomizerSection {

	/**
	 * Panel which section belongs to
	 *
	 * @var string
	 */
	protected static $panel_id = 'panel';

	/**
	 * Section id
	 *
	 * @var string
	 */
	protected static $section_id = 'section';

	/**
	 * Constructor
	 *
	 * Create filter to get all default settings value
	 * Create filter to get all section configurations
	 */
	protected function __construct() {

		add_filter( 'brandy_theme_default_settings', array( $this, 'brandy_theme_default_settings' ) );
		add_filter( 'brandy_' . static::$panel_id . '_customizer_configurations', array( $this, 'get_configurations' ) );
	}

	/**
	 * Callback for brandy_theme_default_settings hook
	 */
	public function brandy_theme_default_settings( $settings ) {
		return array_merge( $settings, $this->get_default_settings() );
	}

	/**
	 * Returns module configurations
	 * If you want to get these configurations alone, please not passing in the configurations
	 *
	 * @param array $configurations Filter configurations.
	 */
	abstract public static function get_configurations( $configurations = array() );

	/**
	 * Returns default settings
	 */
	abstract public static function get_default_settings();
}
