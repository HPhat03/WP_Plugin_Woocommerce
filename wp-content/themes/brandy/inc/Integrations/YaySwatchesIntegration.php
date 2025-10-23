<?php

namespace Brandy\Integrations;

use Brandy\Traits\SingletonTrait;

class YaySwatchesIntegration {
	use SingletonTrait;

	protected function __construct() {
		if ( ! defined( 'YAY_SWATCHES_VERSION' ) ) {
			return;
		}
		add_action( 'wp_head', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() { ?>
		<style>
			.yay-swatches-archive-wrapper {margin-top: .75rem;}
		</style>
		<?php
	}
}
