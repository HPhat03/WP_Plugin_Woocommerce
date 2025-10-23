<?php

namespace Brandy\Builder\Element;

class ElementBuilder {

	protected $element;
	protected $builder;
	protected $device = 'desktop';

	public function __construct( $builder, $element, $device = 'desktop' ) {
		$this->builder = $builder;
		$this->element = $element;
		$this->device  = $device;
	}

	public function render( $in_toggle = false ) {

		if ( isset( $this->element['render_template'] ) && file_exists( $this->element['render_template'] ) ) {
			require $this->element['render_template'];
			return;
		}

		$filter_name = 'brandy_element_' . $this->element['id'] . '_template_path';

		if ( isset( $this->element['cloned_from'] ) ) {
			$filter_name = 'brandy_element_' . $this->element['cloned_from'] . '_template_path';
		}

		get_template_part(
			apply_filters( $filter_name, '' ),
			'',
			array(
				'builder'   => $this->builder,
				'element'   => $this->element,
				'device'    => $this->device,
				'in_toggle' => $in_toggle,
			)
		);
	}

}
