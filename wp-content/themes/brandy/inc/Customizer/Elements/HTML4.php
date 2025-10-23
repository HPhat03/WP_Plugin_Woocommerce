<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class HTML4 extends BaseHTML {

	use SingletonTrait;

	protected $element_id = 'html_4';

	protected function __construct() {
		$this->title = __( 'HTML 4', 'brandy' );
		parent::__construct();
	}
}
