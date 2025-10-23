<?php

namespace Brandy\Builder;

use Brandy\Builder\Footer\FooterBuilder;
use Brandy\Builder\Header\HeaderBuilder;
use Brandy\Traits\SingletonTrait;

class BuilderLoader {
	use SingletonTrait;

	protected function __construct() {

		HeaderBuilder::get_instance();
		FooterBuilder::get_instance();

	}
}

BuilderLoader::get_instance();
