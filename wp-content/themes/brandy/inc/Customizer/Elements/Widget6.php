<?php
namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Widget6 extends BaseWidget {
	use SingletonTrait;

	protected $element_id = 'widget_6';

	protected $builders = array( 'footer' );

	protected function __construct() {
		$this->title = __( 'Widget 6', 'brandy' );
		parent::__construct();
	}

}
