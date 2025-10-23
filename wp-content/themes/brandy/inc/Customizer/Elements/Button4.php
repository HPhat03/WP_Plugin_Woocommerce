<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Button4 extends BaseButton {

	use SingletonTrait;

	protected $element_id = 'button_4';

	protected function __construct() {
		$this->title = __( 'Button 4', 'brandy' );
		parent::__construct();
	}
}
