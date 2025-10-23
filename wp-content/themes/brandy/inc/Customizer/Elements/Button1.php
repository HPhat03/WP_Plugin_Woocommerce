<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Button1 extends BaseButton {

	use SingletonTrait;

	protected $element_id = 'button';

	protected function __construct() {
		$this->title = __( 'Button 1', 'brandy' );
		parent::__construct();
	}
}
