<?php

namespace Brandy\Builder\Header;

use Brandy\Builder\Element\ElementBuilder;
use Brandy\Traits\SingletonTrait;

class ToggleOffCanvasBuilder {
	use SingletonTrait;

	protected function __construct() {
		add_action( 'brandy_toggle_off_canvas', array( $this, 'render_toggle_off_canvas' ) );
	}

	public function render_toggle_off_canvas( $args = array() ) {
		get_template_part( 'template-parts/builder/header/toggle-off-canvas-layout', '', $args );
	}

	public static function render_elements( $device ) {
		$current_template = brandy_get_header_template();
		$element_ids      = $current_template['placements'][ 'tablet' === $device ? 'mobile' : $device ]['toggle'];
		foreach ( $element_ids as $element_id ) {
			$element  = $current_template['elements'][ $element_id ];
			$renderer = new ElementBuilder( 'header', $element );
			$renderer->render( true );
		}
	}

	public static function render_close_icon() { ?>
	<div class="brandy-toc-close-icon">
		<?php ob_start(); ?>
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
		<?php
		$icon = ob_get_contents();
		ob_end_clean();
		brandy_render_icon( $icon );
		?>
	</div>
		<?php
	}

}
