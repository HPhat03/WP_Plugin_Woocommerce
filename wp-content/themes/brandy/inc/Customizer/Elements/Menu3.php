<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Menu3 extends BaseMenuFooter {

	use SingletonTrait;

	protected $element_id = 'menu_3';

	protected function __construct() {
		$this->title = __( 'Menu 3', 'brandy' );
		parent::__construct();
	}

}
