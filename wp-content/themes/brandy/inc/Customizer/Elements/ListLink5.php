<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class ListLink5 extends BaseListLink {

	use SingletonTrait;

	protected $element_id = 'list_link_5';

	protected function __construct() {
		$this->title = __( 'List link 5', 'brandy' );
		parent::__construct();
	}
}
