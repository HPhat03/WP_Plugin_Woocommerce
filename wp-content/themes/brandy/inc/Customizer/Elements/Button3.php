<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Button3 extends BaseButton {

	use SingletonTrait;

	protected $element_id = 'button_3';

	protected function __construct() {
		$this->title = __( 'Button 3', 'brandy' );
		parent::__construct();
	}
}
