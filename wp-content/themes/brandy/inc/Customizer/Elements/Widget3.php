<?php
namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class Widget3 extends BaseWidget {
	use SingletonTrait;

	protected $element_id = 'widget_3';

	protected function __construct() {
		$this->title = __( 'Widget 3', 'brandy' );
		parent::__construct();
	}

}
