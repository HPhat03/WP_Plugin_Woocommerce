<?php

namespace Brandy\Builder;

use Brandy\Builder\Element\ElementBuilder;

class PartialBuilder {

	protected $element_type;
	protected $builder;

	public function __construct( $builder, $element_type ) {
		$this->element_type = $element_type;
		$this->builder      = $builder;
	}

	public function render() {
		$fn = 'brandy_get_' . $this->builder . '_template';
		if ( ! is_callable( $fn ) ) {
			return;
		}
		$current_template = call_user_func( $fn );

		$is_partial_refresh = isset( $_POST['customized'] ) && isset( $_POST['customize_theme'] );
		foreach ( $current_template['elements'] as $element ) {
			if ( $this->element_type === $element['id'] ) {
				$is_toggle = false;
				if ( 'header' === $this->builder && $is_partial_refresh ) {
					global $by_pass_menu_ind;

					if ( empty( $by_pass_menu_ind ) ) {
						$by_pass_menu_ind = 1;
					} else {
						$by_pass_menu_ind++;
					}
					if ( 1 === $by_pass_menu_ind && in_array( $element['id'], $current_template['placements']['desktop']['toggle'] ) ) {
						$is_toggle = true;
					}
					if ( 2 === $by_pass_menu_ind && in_array( $element['id'], $current_template['placements']['mobile']['toggle'] ) ) {
						$is_toggle = true;
					}
				}
				$renderer = new ElementBuilder( $this->builder, $element );
				$renderer->render( $is_toggle );
			}
		}
	}

}
