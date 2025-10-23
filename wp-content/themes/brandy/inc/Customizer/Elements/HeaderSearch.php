<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;

class HeaderSearch extends BaseSearch {

	use SingletonTrait;

	protected $builders = array( 'header' );

	protected $element_id = 'header_search';

}
