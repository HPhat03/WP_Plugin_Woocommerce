<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class ListLink2 extends BaseListLink {

	use SingletonTrait;

	protected $element_id = 'list_link_2';

	protected function __construct() {
		$this->title = __( 'List link 2', 'brandy' );
		parent::__construct();
	}
}
