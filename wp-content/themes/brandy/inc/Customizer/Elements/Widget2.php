<?php
namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Widget2 extends BaseWidget {
	use SingletonTrait;

	protected $element_id = 'widget_2';

	protected function __construct() {
		$this->title = __( 'Widget 2', 'brandy' );
		parent::__construct();
	}

}
