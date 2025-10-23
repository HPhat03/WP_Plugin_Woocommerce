<?php
/**
 * The AbstractCustomizerModuleLoader abstract class is responsible for loading and
 * registering the customizer settings and controls for a module
 *
 * @package Brandy\Customizer
 * @since 1.0.0
 */

namespace Brandy\Abstracts;

/**
 * Declare abstract class
 */
abstract class AbstractCustomizerModuleLoader {

	/**
	 * Constructor
	 */
	protected function __construct() {
		add_action( 'customize_register', array( $this, 'register_customizer' ) );
	}

	/**
	 * Callback for `customize_register` hook
	 * Register header builder modules.
	 *
	 * @param \WP_Customize_Manager $manager Customize manager.
	 */
	public function register_customizer( \WP_Customize_Manager $manager ) {
		$configurations = static::get_configurations();
		foreach ( $configurations as $configuration ) {
			\brandy_register_configuration( $manager, $configuration );
		}
	}

	/**
	 * Returns module configurations
	 * Because this is the main loader, so return panel configurations
	 */
	abstract public static function get_configurations();
}
