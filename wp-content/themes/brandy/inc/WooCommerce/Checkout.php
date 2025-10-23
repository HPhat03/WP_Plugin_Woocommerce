<?php

namespace Brandy\WooCommerce;

use Brandy\Traits\SingletonTrait;

class Checkout {
	use SingletonTrait;

	protected function __construct() {

	}


}

Checkout::get_instance();
