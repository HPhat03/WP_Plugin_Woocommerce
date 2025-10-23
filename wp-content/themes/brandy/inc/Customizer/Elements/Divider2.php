<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Divider2 extends BaseDivider {

	use SingletonTrait;

	protected $element_id = 'divider_2';

	protected function __construct() {
		$this->title = __( 'Divider 2', 'brandy' );
		parent::__construct();
	}
}
