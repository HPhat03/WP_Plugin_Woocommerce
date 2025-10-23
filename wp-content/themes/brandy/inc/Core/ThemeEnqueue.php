<?php
/**
 * The ThemeEnqueue handle enqueueing script and styles for theme layout.
 *
 * @package Brandy\Core
 * @since 1.0
 */

namespace Brandy\Core;

use Brandy\FrontendVite;
use Brandy\Traits\SingletonTrait;

/**
 * Declare class
 */
class ThemeEnqueue {
	use SingletonTrait;

	/**
	 * Constructor
	 */
	protected function __construct() {

		add_editor_style( 'editor-style' );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action(
			'enqueue_block_assets',
			function() {
				global $current_screen;
				if ( ! empty( $current_screen->is_block_editor ) ) {
					wp_enqueue_style( 'brandy-editor-style', BRANDY_TEMPLATE_URL . '/assets/css/admin/editor.min.css', array(), BRANDY_SCRIPT_VERSION );
				}
			}
		);

	}

	/**
	 * Enqueue callback
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'brandy-frontend', BRANDY_TEMPLATE_URL . '/assets/js/frontend.min.js', array_merge( array( 'jquery', 'wp-data' ), is_wc_installed() ? array( 'wc-blocks-data-store' ) : array() ), BRANDY_SCRIPT_VERSION, true );
		wp_localize_script(
			'brandy-frontend',
			'brandyFrontend',
			apply_filters(
				'brandy_frontend_localize',
				array(
					'ajax' => array(
						'path'    => admin_url( 'admin-ajax.php' ),
						'nonces'  => array(
							'update_cart'      => wp_create_nonce( 'brandy_update_cart' ),
							'sendSubscription' => wp_create_nonce( 'send_subscription' ),
						),
						'actions' => array(
							'sendSubscription' => 'brandy_send_subscription',
						),
					),
					'rtl'  => is_rtl(),
					'urls' => array(
						'cart'   => brandy_get_cart_page_url(),
						'assets' => BRANDY_TEMPLATE_URL . '/assets',
					),
				)
			)
		);
		FrontendVite::enqueue_vite();

		/* Enqueue styles */
		if ( is_customize_preview() ) {
			wp_enqueue_style( 'brandy-customize-preview-style', BRANDY_TEMPLATE_URL . '/assets/css/frontend/customize-preview.min.css', array(), BRANDY_SCRIPT_VERSION );
		}
	}

}
