<?php
namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Widget1 extends BaseWidget {
	use SingletonTrait;

	protected $element_id = 'widget_1';

	protected function __construct() {
		$this->title = __( 'Widget 1', 'brandy' );
		parent::__construct();
	}

}
