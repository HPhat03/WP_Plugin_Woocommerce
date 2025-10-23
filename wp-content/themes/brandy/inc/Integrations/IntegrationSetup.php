<?php

namespace Brandy\Integrations;

use Brandy\Integrations\YayCurrencyIntegration;
use Brandy\Integrations\YayExtraIntegration;
use Brandy\Integrations\YayPricingIntegration;
use Brandy\Integrations\YaySwatchesIntegration;
use Brandy\Traits\SingletonTrait;

class IntegrationSetup {
	use SingletonTrait;

	protected function __construct() {
		YayCurrencyIntegration::get_instance();
		YaySwatchesIntegration::get_instance();
		YayPricingIntegration::get_instance();
		YayExtraIntegration::get_instance();
	}
}

IntegrationSetup::get_instance();
