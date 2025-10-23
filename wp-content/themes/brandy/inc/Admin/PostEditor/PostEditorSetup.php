<?php

namespace Brandy\Admin\PostEditor;

use Brandy\Traits\SingletonTrait;

class PostEditorSetup {
	use SingletonTrait;

	protected function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_scripts' ) );

		PostMetaServices::get_instance()->register_metae();
	}

	public function enqueue_scripts() {
		$screen = get_current_screen();
		if ( ! empty( $screen->is_block_editor ) ) {
			PostEditorVite::enqueue_vite( 'main.jsx', '3006' );
			wp_localize_script(
				'module/brandy-post-editor/main.jsx',
				'brandyBlockEditorData',
				array(
					'links' => array(
						'customizer' => admin_url( 'customize.php' ),
					),
				)
			);
			wp_localize_script(
				'module/brandy-post-editor/main.jsx',
				'brandyBlockEditorHeaderSettings',
				brandy_get_header_settings()
			);
			wp_localize_script(
				'module/brandy-post-editor/main.jsx',
				'brandyBlockEditorFooterSettings',
				brandy_get_footer_settings()
			);
			wp_enqueue_script( 'brandy-editor-script', BRANDY_TEMPLATE_URL . '/inc/Admin/PostEditor/editor-script.js', array( 'jquery' ), time(), true );
		}
	}
}
