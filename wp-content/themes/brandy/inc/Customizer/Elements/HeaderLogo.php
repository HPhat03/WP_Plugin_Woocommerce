<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class HeaderLogo extends BaseLogo {

	use SingletonTrait;

	protected $element_id = 'logo_1';

	protected $builders = array( 'header' );

	protected function __construct() {
		$this->title = __( 'Logo', 'brandy' );
		parent::__construct();
	}
}
