<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class LanguageSwitcher extends BaseLanguageSwitcher {

	use SingletonTrait;

	protected $element_id = 'language_switcher_1';

	protected $builders = array( 'header', 'footer' );

	protected function __construct() {
		$this->title = __( 'Language switcher', 'brandy' );
		parent::__construct();
	}
}
