<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class FooterSocials extends BaseSocials {

	use SingletonTrait;

	protected $element_id = 'socials_2';

	protected $builders = array( 'footer' );

	protected function __construct() {
		$this->title = __( 'Socials', 'brandy' );
		parent::__construct();
	}
}
