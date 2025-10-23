<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class ListLink1 extends BaseListLink {

	use SingletonTrait;

	protected $element_id = 'list_link_1';

	protected function __construct() {
		$this->title = __( 'List link 1', 'brandy' );
		parent::__construct();
	}
}
