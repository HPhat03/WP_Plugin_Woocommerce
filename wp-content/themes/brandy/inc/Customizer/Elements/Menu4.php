<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Menu4 extends BaseMenuFooter {

	use SingletonTrait;

	protected $element_id = 'menu_4';

	protected function __construct() {
		$this->title = __( 'Menu 4', 'brandy' );
		parent::__construct();
	}

}
