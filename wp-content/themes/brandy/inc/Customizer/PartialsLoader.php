<?php

namespace Brandy\Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Brandy\Builder\Footer\FooterBuilder;
use Brandy\Builder\Header\HeaderBuilder;
use Brandy\DynamicCss;
use Brandy\Traits\SingletonTrait;

class PartialsLoader {
	use SingletonTrait;

	protected function __construct() {
		add_action( 'customize_register', array( $this, 'register_partials' ), 200 );
	}

	public function register_partials( \WP_Customize_Manager $manager ) {
		$partials      = $this->get_partials();
		$tied_settings = array();
		foreach ( $partials as $configuration ) {
			$id              = $configuration['id'];
			$tied_settings[] = $id;
			$manager->add_setting(
				$id,
				array(
					'default'   => $configuration['default'],
					'transport' => $configuration['transport'],
				)
			);
			$manager->selective_refresh->add_partial( $id, $configuration['partial'] );
		}
		$manager->selective_refresh->add_partial(
			'brandy_dynamic_css',
			array(
				'selector'            => 'style#brandy-dynamic-css',
				'settings'            => $tied_settings,
				'render_callback'     => array( DynamicCss::get_instance(), 'print_dynamic_css' ),
				'container_inclusive' => false,
				'fallback_refresh'    => false,
			)
		);

		// Make sure the setting exists (it might be added by a theme/plugin)
		if ( $setting = $manager->get_setting( 'blogname' ) ) {
			$setting->transport = 'postMessage';   // or 'refresh'
		}
		if ( $setting = $manager->get_setting( 'blogdescription' ) ) {
			$setting->transport = 'postMessage';   // or 'refresh'
		}
	}

	private function get_partials() {
		return apply_filters(
			'brandy_partial_refresh',
			array(
				array(
					'configuration_type' => 'control',
					'id'                 => 'header_placements',
					'partial'            => array(
						'selector'            => '#brandy-header',
						'render_callback'     => array( HeaderBuilder::get_instance(), 'render_header' ),
						'container_inclusive' => true,
						'fallback_refresh'    => true,
					),
					'default'            => '',
					'transport'          => 'postMessage',
				),
				array(
					'configuration_type' => 'control',
					'id'                 => 'footer_placements',
					'partial'            => array(
						'selector'            => '#brandy-footer',
						'render_callback'     => array( FooterBuilder::get_instance(), 'render_footer' ),
						'container_inclusive' => true,
						'fallback_refresh'    => true,
					),
					'default'            => '',
					'transport'          => 'postMessage',
				),
			)
		);
	}
}
