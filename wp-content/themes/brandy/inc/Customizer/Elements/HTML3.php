<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class HTML3 extends BaseHTML {

	use SingletonTrait;

	protected $element_id = 'html_3';

	protected function __construct() {
		$this->title = __( 'HTML 3', 'brandy' );
		parent::__construct();
	}
}
