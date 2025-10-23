<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class ListLink3 extends BaseListLink {

	use SingletonTrait;

	protected $element_id = 'list_link_3';

	protected function __construct() {
		$this->title = __( 'List link 3', 'brandy' );
		parent::__construct();
	}
}
