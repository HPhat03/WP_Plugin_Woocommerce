<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class HeaderSocials extends BaseSocials {

	use SingletonTrait;

	protected $element_id = 'socials_1';

	protected $builders = array( 'header' );

	protected function __construct() {
		$this->title = __( 'Socials', 'brandy' );
		parent::__construct();
	}
}
