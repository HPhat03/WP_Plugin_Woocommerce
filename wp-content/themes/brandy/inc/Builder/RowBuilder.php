<?php

namespace Brandy\Builder;

class RowBuilder {

	protected $builder = 'header';
	protected $row     = 'top';
	protected $device  = 'desktop';

	public function __construct( $builder, $row, $device ) {
		$this->builder = $builder;
		$this->row     = $row;
		$this->device  = $device;
	}

	public function render() {
		$builder = $this->builder;
		if ( 'tablet' === $this->device ) {
			return;
		}
		get_template_part(
			"template-parts/builder/$builder/$builder-row-layout",
			'',
			array(
				'row'    => $this->row,
				'device' => $this->device,
			)
		);
	}

}
