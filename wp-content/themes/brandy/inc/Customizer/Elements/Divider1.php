<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Divider1 extends BaseDivider {

	use SingletonTrait;

	protected $element_id = 'divider_1';

	protected function __construct() {
		$this->title = __( 'Divider 1', 'brandy' );
		parent::__construct();
	}
}
