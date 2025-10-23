<?php

namespace Brandy\Integrations;

use Brandy\Traits\SingletonTrait;

class YayCurrencyIntegration {
	use SingletonTrait;

	protected function __construct() {
		if ( ! defined( 'YAY_CURRENCY_VERSION' ) ) {
			return;
		}
		add_action( 'wp_head', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() { ?>
		<style>
			.brandy-menu-element .yay-currency-single-page-switcher {
				margin-bottom: 0;
			}

		</style>
		<?php
	}
}
