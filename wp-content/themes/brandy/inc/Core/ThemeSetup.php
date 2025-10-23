<?php

namespace Brandy\Core;

use Brandy\Core\Services\StringVariablesService;
use Brandy\Traits\SingletonTrait;
use Brandy\Utils\MenuHelper;

class ThemeSetup {
	use SingletonTrait;

	protected function __construct() {
		add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );

		add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'init', array( $this, 'register_block_patterns_and_categories' ) );
		add_action( 'init', array( $this, 'unregister_wc_patterns_when_necessary' ) );
		add_action( 'init', array( $this, 'unregister_brandy_blocks_patterns_when_necessary' ) );

		add_filter( 'get_block_templates', array( $this, 'remove_wc_templates_when_necessary' ) );

		$this->hjack_setup();
	}

	public function add_theme_supports() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support(
			'woocommerce',
			array(
				'thumbnail_image_width' => 800,
				'single_image_width'    => 800,
			)
		);
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'custom-background', array() );
		add_theme_support( 'custom-header', array() );
		add_theme_support( 'custom-logo', array() );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'post-thumbnails' );

	}

	public function register_menus() {
		register_nav_menus( MenuHelper::get_locations() );
	}

	public function register_block_patterns_and_categories() {
		register_block_pattern_category( 'brandy', array( 'label' => __( 'Brandy', 'brandy' ) ) );
	}

	public function unregister_wc_patterns_when_necessary() {

		if ( is_wc_installed() ) {
			return;
		}

		$themes   = array();
		$theme    = wp_get_theme();
		$themes[] = $theme;
		if ( $theme->parent() ) {
			$themes[] = $theme->parent();
		}
		$patterns = array();

		foreach ( $themes as $theme ) {
			$patterns = array_merge( $patterns, $theme->get_block_patterns() );
		}

		foreach ( $patterns as $pattern_name => $pattern ) {
			if ( empty( $pattern['categories'] ) ) {
				continue;
			}
			if ( in_array( 'woocommerce', $pattern['categories'], true ) ) {
				unregister_block_pattern( $pattern['slug'] );
			}
		}

	}

	public function unregister_brandy_blocks_patterns_when_necessary() {

		if ( is_brandy_blocks_installed() ) {
			return;
		}

		$themes   = array();
		$theme    = wp_get_theme();
		$themes[] = $theme;
		if ( $theme->parent() ) {
			$themes[] = $theme->parent();
		}
		$patterns = array();

		foreach ( $themes as $theme ) {
			$patterns = array_merge( $patterns, $theme->get_block_patterns() );
		}

		foreach ( $patterns as $pattern_name => $pattern ) {
			if ( empty( $pattern['categories'] ) ) {
				continue;
			}
			if ( in_array( 'brandy-blocks', $pattern['categories'], true ) ) {
				unregister_block_pattern( $pattern['slug'] );
			}
			if ( 'brandy/simple-contact-form' === $pattern['slug'] ) {
				unregister_block_pattern( $pattern['slug'] );
			}
		}

	}

	public function remove_wc_templates_when_necessary( $query_result ) {
		if ( is_wc_installed() ) {
			return $query_result;
		}

		$removal_template_slugs = array(
			'archive-product',
			'order-confirmation',
			'page-cart',
			'page-checkout',
			'page-my-account',
			'product-search-results',
			'single-product',
		);

		$query_result = array_filter(
			$query_result,
			function( $template ) use ( $removal_template_slugs ) {
				if ( false === strpos( $template->theme, 'brandy' ) && false === strpos( $template->id, 'brandy' ) ) {
					return true;
				}
				return ! in_array( $template->slug, $removal_template_slugs, true );
			}
		);

		return $query_result;
	}

	public function hjack_setup() {

		// Trick to add outline style for button element
		add_action(
			'init',
			function() {
				$parsed_block = array(
					'attrs'     => array(
						'className' => 'wp-block-button is-style-outline',
					),
					'blockName' => 'core/button',
				);
				if ( function_exists( '\wp_render_block_style_variation_support_styles' ) ) {
					\wp_render_block_style_variation_support_styles( $parsed_block );
				}
			}
		);

		add_filter(
			'wp_prepare_themes_for_js',
			function( $themes ) {
				if ( isset( $themes['brandy']['actions']['customize'] ) ) {
					$themes['brandy']['actions']['customize'] = wp_customize_url( 'brandy' );
				}
				return $themes;
			}
		);

		add_filter(
			'script_loader_tag',
			function( $tag, $handle ) {
				if ( strpos( $handle, 'brandy' ) !== false ) {
					return str_replace( ' src=', ' defer src=', $tag );
				}
				return $tag;
			},
			10,
			2
		);

		add_filter(
			'theme_scandir_exclusions',
			function( $exclusions ) {
				if ( ! isset( $_POST['themename'] ) || 'brandy' !== $_POST['themename'] ) {
					return $exclusions;
				}
				if ( ! check_admin_referer( 'themecheck-nonce' ) ) {
					return $exclusions;
				}
				$exclusions[] = 'icons';
				$exclusions[] = 'Elements';
				return $exclusions;
			}
		);
	}

}

ThemeSetup::get_instance();
