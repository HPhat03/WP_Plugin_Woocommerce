<?php

namespace Brandy\Abstracts;

use Brandy\Builder\PartialBuilder;
use Brandy\Utils\Helpers;

abstract class AbstractLayout {
	protected $components = array();

	protected $section_id = null;

	protected $layout = array();

	protected function __construct() {

		add_filter( 'brandy_settings_layouts', array( $this, 'add_layout' ) );
		add_filter( 'brandy_partial_refresh', array( $this, 'add_partial_refresh' ) );
		add_filter( 'brandy_all_registered_settings', array( $this, 'add_registered_settings' ) );

		$this->components = $this->register_components();

		$this->layout = $this->register_layout();

	}

	public function add_layout( $layouts = array() ) {
		$mapped_layout                = $this->map_layout( $this->layout );
		$layouts[ $this->section_id ] = $mapped_layout;
		return $layouts;
	}

	protected function register_components() {
		return array();
	}

	public function add_registered_settings( $settings = array() ) {
		$settings[ $this->section_id ] = $this->components;
		return $settings;
	}

	protected function register_layout() {
		return array(
			'general' => array(
				'sections' => array(),
			),
			'designs' => array(
				'sections' => array(),
			),
		);
	}

	protected function map_settings( $components ) {
		$result = array();
		foreach ( $components as $component ) {
			if ( empty( $component['value_path'] ) && empty( $component['default_value'] ) ) {
				continue;
			}
			$path          = $component['value_path'];
			$default_value = $component['default_value'];
			Helpers::set_nested_value( $result, $path, $default_value );
		}
		return $result;
	}

	protected function map_layout( $layout ) {
		foreach ( array_keys( $layout ) as $tab ) {
			foreach ( $layout[ $tab ]['sections'] as $index => $section ) {
				$layout[ $tab ]['sections'][ $index ]['components'] =
				array_reduce(
					$section['components'],
					function( $prev, $component_id ) {
						if ( isset( $this->components[ $component_id ] ) ) {
							$prev[] = $this->components[ $component_id ];
						}
						return $prev;
					},
					array()
				);
			}
		}
		return $layout;
	}

	public function add_partial_refresh( $partials = array() ) {
		$partials[] = array(
			'configuration_type' => 'control',
			'id'                 => $this->section_id,
			'partial'            => array(
				'selector'            => "[data-section-id='" . $this->section_id . "']",
				'render_callback'     => array( new PartialBuilder( 'header', $this->section_id ), 'render' ),
				'container_inclusive' => true,
				'fallback_refresh'    => true,
			),
			'default'            => '',
			'transport'          => 'postMessage',
		);
		return $partials;
	}

	public function get_settings() {
		return $this->map_settings( $this->components );
	}
}
