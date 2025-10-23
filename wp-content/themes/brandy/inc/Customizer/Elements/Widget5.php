<?php
namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Widget5 extends BaseWidget {
	use SingletonTrait;

	protected $element_id = 'widget_5';

	protected $builders = array( 'footer' );

	protected function __construct() {
		$this->title = __( 'Widget 5', 'brandy' );
		parent::__construct();
	}

}
