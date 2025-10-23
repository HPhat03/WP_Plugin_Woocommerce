<?php

namespace Brandy\Abstracts;

use Brandy\Builder\PartialBuilder;

abstract class AbstractBaseElement extends AbstractLayout {
	protected $components = array();

	protected $element_id = null;

	protected $builders = array( 'header' );

	protected $icon = '';

	protected $title = '';

	protected $layout = array();

	protected function __construct() {

		add_filter( 'brandy_element_' . $this->element_id . '_template_path', array( $this, 'template_path' ) );

		$this->section_id = $this->element_id;

		parent::__construct();

		add_filter( 'brandy_all_elements', array( $this, 'register_element' ) );

	}

	public function template_path() {
		return 'template-parts/builder/elements/' . $this->element_id;
	}

	public function register_element( $elements = array() ) {
		$elements[ $this->element_id ] = array(
			'id'       => $this->element_id,
			'title'    => $this->title,
			'settings' => $this->get_settings(),
			'builders' => $this->builders,
			'icon'     => $this->icon,
		);
		return $elements;
	}

	public function add_layout( $layouts = array() ) {
		$mapped_layout                = $this->map_layout( $this->layout );
		$layouts[ $this->element_id ] = $mapped_layout;
		return $layouts;
	}

	public function add_partial_refresh( $partials = array() ) {
		foreach ( $this->builders as $builder ) {
			$partials[] = array(
				'configuration_type' => 'control',
				'id'                 => $builder . '_' . $this->element_id,
				'partial'            => array(
					'selector'            => "[data-section-id='" . $this->element_id . "'][data-builder='" . $builder . "']",
					'render_callback'     => array( new PartialBuilder( $builder, $this->element_id ), 'render' ),
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
				'default'            => '',
				'transport'          => 'postMessage',
			);
		}
		return $partials;
	}

}
