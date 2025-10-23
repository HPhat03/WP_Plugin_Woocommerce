<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class HTML1 extends BaseHTML {

	use SingletonTrait;

	protected $element_id = 'html_1';

	protected function __construct() {
		$this->title = __( 'HTML 1', 'brandy' );
		parent::__construct();
	}
}
