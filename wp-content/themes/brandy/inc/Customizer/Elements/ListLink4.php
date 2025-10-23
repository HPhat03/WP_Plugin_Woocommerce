<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class ListLink4 extends BaseListLink {

	use SingletonTrait;

	protected $element_id = 'list_link_4';

	protected function __construct() {
		$this->title = __( 'List link 4', 'brandy' );
		parent::__construct();
	}
}
