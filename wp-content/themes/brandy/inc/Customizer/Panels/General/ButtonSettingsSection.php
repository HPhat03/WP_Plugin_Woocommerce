<?php
/**
 * The Button Settings Section class is responsible for loading and
 * registering the customizer settings and controls for the Header Builder module.
 *
 * @package Brandy\Customizer
 * @since   1.0.0
 */

namespace Brandy\Customizer\Panels\General;

use Brandy\Abstracts\AbstractCustomizerModuleLoader;
use Brandy\Core\Services\ButtonService;
use Brandy\Traits\SingletonTrait;

/**
 * Register Header stuffs
 * Header panel and section are registered here
 */
class ButtonSettingsSection extends AbstractCustomizerModuleLoader {

	use SingletonTrait;

	public const SECTION_ID = 'button_settings';

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
			'title'              => __( 'Button Settings', 'brandy' ),
			'panel'              => GeneralPanel::PANEL_ID,
			'type'               => 'brandy-section',
			'description_hidden' => true,
		);
		$configurations[] = array(
			'configuration_type' => 'control',
			'id'                 => self::SECTION_ID,
			'label'              => __( 'Button Settings', 'brandy' ),
			'section'            => self::SECTION_ID,
			'type'               => 'brandy_settings',
			'input_attrs'        => array(
				'value' => '',
				'style' => 'display:none;',
			),
			'partial'            => false,
			'default'            => self::default_settings(),
			'transport'          => 'postMessage',
		);

		return $configurations;
	}

	public static function default_settings() {
		return [
			'type' => 'default',
			'color' => 'var(--wp--preset--color--brandy-primary-text)',
			'hoverColor' => 'var(--wp--preset--color--brandy-primary-text)',
			'textColor' => 'var(--wp--preset--color--white)',
			'textHoverColor' => 'var(--wp--preset--color--white)',
		];
	}

	public function print_global_css() {
		if ( ! is_customize_preview() ) {
			return;
		}

		$global_styles = wp_get_global_styles();
		$color = $global_styles['elements']['button']['color']['background'];
		$hoverColor = $global_styles['elements']['button'][':hover']['color']['background'];
		$textColor = $global_styles['elements']['button']['color']['text'];
		$textHoverColor = $global_styles['elements']['button'][':hover']['color']['text'];

		$button_settings = ButtonService::get_settings();

		$button_variables = [];

		if ( isset($button_settings['primaryColor']) ) {
			$button_variables[] = "--button-primary: {$button_settings['primaryColor']};";
		}
		if ( isset($button_settings['primaryHoverColor']) ) {
			$button_variables[] = "--button-primary-hover: {$button_settings['primaryHoverColor']};";
		}
		if ( isset($button_settings['primaryTextColor']) ) {
			$button_variables[] = "--button-primary-text: {$button_settings['primaryTextColor']};";
		}
		if ( isset($button_settings['primaryTextHoverColor']) ) {
			$button_variables[] = "--button-primary-text-hover: {$button_settings['primaryTextHoverColor']};";
		}

		if ( ! empty( $button_variables ) ) {
			echo " body { " . implode( '', $button_variables ) . "} ";
		}
		
		echo "
		  body.custom-button-style .wp-block-button:not(.is-style-outline) .wp-element-button {
			background-color: var(--button-primary, $color);
			color: var(--button-primary-text, $textColor);
		  }
		  body.custom-button-style .wp-block-button:not(.is-style-outline) .wp-element-button:hover {
			background-color: var(--button-primary-hover, $hoverColor);
			color: var(--button-primary-text-hover, $textHoverColor);
		  }
		  body.custom-button-style .wp-block-button.is-style-outline .wp-element-button {
		    background-color: #ffffff00;
			border-color: var(--button-primary, $color);
			color: var(--button-primary, $color);
		  }
		  body.custom-button-style .wp-block-button.is-style-outline .wp-element-button:hover {
			background-color: var(--button-primary, $color);
			border-color: var(--button-primary, $color);
			color: var(--button-primary-text, $textColor);
		  }
		";
	}

}
