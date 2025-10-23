<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class HTML2 extends BaseHTML {

	use SingletonTrait;

	protected $element_id = 'html_2';

	protected function __construct() {
		$this->title = __( 'HTML 2', 'brandy' );
		parent::__construct();
	}
}
