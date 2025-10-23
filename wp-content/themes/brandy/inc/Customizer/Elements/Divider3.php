<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Divider3 extends BaseDivider {

	use SingletonTrait;

	protected $element_id = 'divider_3';

	protected function __construct() {
		$this->title = __( 'Divider 3', 'brandy' );
		parent::__construct();
	}
}
