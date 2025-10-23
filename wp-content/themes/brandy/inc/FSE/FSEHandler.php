<?php

namespace Brandy\FSE;

use Brandy\Traits\SingletonTrait;

/**
 * Manage FSE and legacy together
 */
class FSEHandler {
	use SingletonTrait;

	protected function __construct() {

		/**
		 * Hjack for render header/footer while using FSE
		 */
		add_filter( 'template_include', array( $this, 'change_canvas_template' ) );

		/**
		 * Handle duplicate coming soon content
		 */
		add_filter( 'coming-soon_template', array( $this, 'remove_coming_soon_template_by_default' ) );
	}

	public function change_canvas_template() {
		return __DIR__ . '/templates/default-canvas.php';
	}

	public function remove_coming_soon_template_by_default() {
		return '';
	}
}

FSEHandler::get_instance();
