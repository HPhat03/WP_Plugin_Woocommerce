<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class FooterLogo extends BaseLogo {

	use SingletonTrait;

	protected $element_id = 'logo_2';

	protected $builders = array( 'footer' );

	protected function __construct() {
		$this->title = __( 'Logo', 'brandy' );
		parent::__construct();
	}

	public function add_layout( $layouts = array() ) {
		$layouts = parent::add_layout( $layouts );
		array_splice( $layouts[ $this->element_id ]['general']['sections'], 3, 1 );
		return $layouts;
	}

	protected function register_components() {
		$components = parent::register_components();
		unset( $components['sticky_logo_enabled'] );
		unset( $components['sticky_logo_url'] );
		unset( $components['sticky_logo_height'] );
		return $components;
	}
}
