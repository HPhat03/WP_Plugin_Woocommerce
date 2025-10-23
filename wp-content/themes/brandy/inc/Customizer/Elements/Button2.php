<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Button2 extends BaseButton {

	use SingletonTrait;

	protected $element_id = 'button_2';

	protected function __construct() {
		$this->title = __( 'Button 2', 'brandy' );
		parent::__construct();
	}
}
