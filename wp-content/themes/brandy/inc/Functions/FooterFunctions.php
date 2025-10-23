<?php
/**
 * Register theme footer functions
 *
 * @package Brandy\Functions
 */

use Brandy\Admin\PostEditor\MetaServices\FooterTemplateMetaService;
use Brandy\Customizer\Panels\FooterPanel;
use Brandy\Utils\Helpers;

if ( ! function_exists( 'brandy_footer' ) ) {
	/**
	 * Render footer
	 */
	function brandy_footer() {
		do_action( 'brandy_footer' );
	}
}

if ( ! function_exists( 'brandy_get_footer_template' ) ) {
	/**
	 * Get current footer template
	 */
	function brandy_get_footer_template() {
		$footer_settings          = brandy_get_footer_settings();
		$footer_layout_meta_value = FooterTemplateMetaService::get_value( brandy_get_current_page_id() );
		$templates                = $footer_settings['templates'];
		$default_template         = null;
		$current_template         = null;

		$meta_template_id = 'inherit';
		if ( 'inherit' !== $footer_layout_meta_value ) {
			foreach ( $templates as $template ) {
				if ( $template['id'] === $footer_layout_meta_value ) {
					$meta_template_id = $template['id'];
				}
			}
		}

		if ( is_customize_preview() ) {
			$template_id = $footer_settings['preview_template_id'] ?? ( 'inherit' !== $meta_template_id ? $meta_template_id : $footer_settings['current_template_id'] );
		} else {
			$template_id = 'inherit' !== $meta_template_id ? $meta_template_id : $footer_settings['current_template_id'];
		}

		$cached_template = wp_cache_get( 'brandy_footer_template_' . $template_id );
		if ( $cached_template ) {
			return $cached_template;
		}

		foreach ( $templates as $template ) {
			if ( 'preset_default' === $template['id'] ) {
				$default_template = $template;
			}
			if ( $template['id'] === $template_id ) {
				$current_template = $template;
			}
		}
		$default_template_data = FooterPanel::get_default_template();
		$current_template = Helpers::recursive_wp_parse_args( $current_template, $default_template_data );
		$result = empty( $current_template ) ? $default_template : $current_template;
		wp_cache_set( 'brandy_footer_template_' . $template_id, $result );
		return $result;
	}
}

if ( ! function_exists( 'brandy_get_footer_settings' ) ) {
	/**
	 * Get footer settings
	 */
	function brandy_get_footer_settings() {

		$is_partial_refresh = isset( $_POST['customized'] ) && isset( $_POST['customize_theme'] );

		if ( $is_partial_refresh ) {
			$customized = json_decode( wp_unslash( $_POST['customized'] ), true );
			if ( ! empty( $customized['unsaved_footer_settings'] ) ) {
				brandy_update_unsaved_footer_settings( $customized['unsaved_footer_settings'] );
			}
		}

		if ( $is_partial_refresh ) {
			$footer_settings = brandy_get_unsaved_footer_settings();
		}
		if ( empty( $footer_settings ) ) {
			$footer_settings = get_option( 'brandy_footer_settings' );
		}
		/**
		 * TODO: Need to apply migrated data when having new properties.
		 */
		if ( empty( $footer_settings ) ) {
			$footer_settings = FooterPanel::get_default_settings();
		}
		return $footer_settings;
	}
}

if ( ! function_exists( 'brandy_save_footer_settings' ) ) {
	/**
	 * Save footer settings
	 */
	function brandy_save_footer_settings( $value ) {
		// set_theme_mod( 'footer_settings', $value );
		update_option( 'brandy_footer_settings', $value );
		brandy_delete_unsaved_footer_settings();
	}
}

if ( ! function_exists( 'brandy_get_unsaved_footer_settings' ) ) {
	function brandy_get_unsaved_footer_settings() {
		return get_option( 'brandy_unsaved_footer_settings' );
	}
}
if ( ! function_exists( 'brandy_add_unsaved_footer_settings' ) ) {
	function brandy_update_unsaved_footer_settings( $value ) {
		if ( empty( $value ) ) {
			return;
		}
		update_option( 'brandy_unsaved_footer_settings', $value );
	}
}
if ( ! function_exists( 'brandy_delete_unsaved_footer_settings' ) ) {
	function brandy_delete_unsaved_footer_settings() {
		delete_option( 'brandy_unsaved_footer_settings' );
	}
}


