<?php
/**
 * Register theme header functions
 *
 * @package Brandy\Functions
 */

use Brandy\Admin\PostEditor\MetaServices\HeaderTemplateMetaService;
use Brandy\Customizer\Panels\HeaderPanel;
use Brandy\Utils\Helpers;

if ( ! function_exists( 'brandy_header' ) ) {
	/**
	 * Render header
	 */
	function brandy_header() {
		do_action( 'brandy_header' );
	}
}

if ( ! function_exists( 'brandy_get_header_template' ) ) {
	/**
	 * Get current header template
	 */
	function brandy_get_header_template() {
		$header_settings          = brandy_get_header_settings();
		$header_layout_meta_value = HeaderTemplateMetaService::get_value( brandy_get_current_page_id() );
		$templates                = $header_settings['templates'];
		$default_template         = null;
		$current_template         = null;

		$meta_template_id = 'inherit';
		if ( 'inherit' !== $header_layout_meta_value ) {
			foreach ( $templates as $template ) {
				if ( $template['id'] === $header_layout_meta_value ) {
					$meta_template_id = $template['id'];
				}
			}
		}

		if ( is_customize_preview() ) {
			$template_id = $header_settings['preview_template_id'] ?? ( 'inherit' !== $meta_template_id ? $meta_template_id : $header_settings['current_template_id'] );
		} else {
			$template_id = 'inherit' !== $meta_template_id ? $meta_template_id : $header_settings['current_template_id'];
		}
		$cached_template = wp_cache_get( 'brandy_header_template_' . $template_id );
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
		$default_template_data = HeaderPanel::get_default_template();
		$current_template = Helpers::recursive_wp_parse_args( $current_template, $default_template_data );
		$result = empty( $current_template ) ? $default_template : $current_template;
		wp_cache_set( 'brandy_header_template_' . $template_id, $result );
		return $result;
	}
}

if ( ! function_exists( 'brandy_get_header_settings' ) ) {
	/**
	 * Get header settings
	 */
	function brandy_get_header_settings() {

		$is_partial_refresh = isset( $_POST['customized'] ) && isset( $_POST['customize_theme'] );

		if ( $is_partial_refresh ) {
			$customized = json_decode( wp_unslash( $_POST['customized'] ), true );
			if ( ! empty( $customized['unsaved_header_settings'] ) ) {
				brandy_update_unsaved_header_settings( $customized['unsaved_header_settings'] );
			}
		}
		if ( $is_partial_refresh ) {
			$header_settings = brandy_get_unsaved_header_settings();
		}

		if ( empty( $header_settings ) ) {
			$header_settings = get_option( 'brandy_header_settings' );
		}
		/**
		 * TODO: Need to apply migrated data when having new properties.
		 */
		if ( empty( $header_settings ) ) {
			$header_settings = HeaderPanel::get_default_settings();
		}
		return $header_settings;
	}
}

if ( ! function_exists( 'brandy_save_header_settings' ) ) {
	/**
	 * Save header settings
	 */
	function brandy_save_header_settings( $value ) {

		// set_theme_mod( 'header_settings', $value );
		update_option( 'brandy_header_settings', $value );
		brandy_delete_unsaved_header_settings();
	}
}

if ( ! function_exists( 'brandy_get_unsaved_header_settings' ) ) {
	function brandy_get_unsaved_header_settings() {
		return get_option( 'brandy_unsaved_header_settings' );
	}
}
if ( ! function_exists( 'brandy_add_unsaved_header_settings' ) ) {
	function brandy_update_unsaved_header_settings( $value ) {
		if ( empty( $value ) ) {
			return;
		}
		update_option( 'brandy_unsaved_header_settings', $value );
	}
}
if ( ! function_exists( 'brandy_delete_unsaved_header_settings' ) ) {
	function brandy_delete_unsaved_header_settings() {
		delete_option( 'brandy_unsaved_header_settings' );
	}
}