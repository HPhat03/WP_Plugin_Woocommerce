<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Menu1 extends BaseMenu {

	use SingletonTrait;

	protected $element_id = 'menu_1';

	protected function __construct() {
		$this->title = __( 'Menu 1', 'brandy' );
		parent::__construct();
	}
}
