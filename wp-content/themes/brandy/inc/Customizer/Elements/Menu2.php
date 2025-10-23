<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Menu2 extends BaseMenu {

	use SingletonTrait;

	protected $element_id = 'menu_2';

	protected function __construct() {
		$this->title = __( 'Menu 2', 'brandy' );
		parent::__construct();
	}
}
