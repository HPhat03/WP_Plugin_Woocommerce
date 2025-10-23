<?php
namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Widget4 extends BaseWidget {
	use SingletonTrait;

	protected $element_id = 'widget_4';

	protected function __construct() {
		$this->title = __( 'Widget 4', 'brandy' );
		parent::__construct();
	}

}
