<?php

namespace Brandy\Abstracts;

use Brandy\Admin\PostEditor\MetaServices\FooterTemplateMetaService;
use Brandy\Admin\PostEditor\MetaServices\HeaderTemplateMetaService;
use Brandy\Customizer\Panels\General\ButtonSettingsSection;

/**
 * Abstract class for niche setup in the Brandy theme.
 */
abstract class AbstractNicheSetup {

	/**
	 * Niche identifier.
	 */
	public const NICHE_ID = '';

	/**
	 * Root path to the niche files.
	 */
	public const ROOT_PATH = '';

	/**
	 * Root URL for the niche.
	 */
	public const ROOT_URL = '';

	/**
	 * Path to the niche JSON configuration file.
	 */
	protected const JSON_FILE = '';

	/**
	 * Niche mode.
	 */
	protected const NICHE_MODE = '';

	/**
	 * Niche name.
	 */
	protected const NICHE_NAME = '';

	/**
	 * Niche thumbnail.
	 */
	protected const NICHE_THUMBNAIL = '';

	/**
	 * Niche demo URL.
	 */
	protected const NICHE_DEMO_URL = 'https://brandydemo.com/default/';

	/**
	 * Niche plan.
	 */
	protected const NICHE_PLAN = 'free';

	/**
	 * Niche tags.
	 */
	protected const NICHE_TAGS = ['ecommerce'];

	/**
	 * Niche supports.
	 */
	protected const NICHE_SUPPORTS = ['gutenberg'];

	/**
	 * Niche product layout.
	 */
	protected const NICHE_PRODUCT_LAYOUT = 'option_1';

	/**
	 * Niche product thumb size.
	 */
	protected const NICHE_PRODUCT_THUMB_SIZE = 'size_2';
	
	/**
	 * Niche product gallery thumb image width.
	 */
	protected const NICHE_PRODUCT_GALLERY_THUMB_IMAGE_WIDTH = 100;
	
	
	/**
	 * Niche product gallery thumb image height.
	 */
	protected const NICHE_PRODUCT_GALLERY_THUMB_IMAGE_HEIGHT = 100;
	
	
	/**
	 * Niche primary hover color.
	 */
	protected const NICHE_PRIMARY_HOVER_COLOR = '#ffffff';
	

	/**
	 * Niche primary hover background color.
	 */
	protected const NICHE_PRIMARY_HOVER_BACKGROUND_COLOR = 'var(--wp--preset--color--brandy-primary-text)';
	
	
	/**
	 * Niche outline hover color.
	 */
	protected const NICHE_OUTLINE_HOVER_COLOR = '#ffffff';
	
	
	/**
	 * Niche outline hover border color.
	 */
	protected const NICHE_OUTLINE_HOVER_BORDER_COLOR = 'var(--wp--preset--color--brandy-primary-text)';
	
	
	/**
	 * Niche outline hover background color.
	 */
	protected const NICHE_OUTLINE_HOVER_BACKGROUND_COLOR = 'var(--wp--preset--color--brandy-primary-text)';

	/**
	 * Array of headers to be replaced.
	 */
	protected const HEADERS = array();

	/**
	 * Array of footers to be replaced.
	 */
	protected const FOOTERS = array();

	/**
	 * Constructor.
	 */
	protected function __construct() {
		add_action( 'init', array( $this, 'init_action' ), 9 );
	}

	/**
	 * Initialize actions and filters.
	 *
	 * @return void
	 */
	public function init_action() {
		add_action( 'brandy_after_import_menus', array( $this, 'after_import_menus' ), 10, 2 );
		
		if ( self::is_current_niche() ) {
			$this->register_current_niche_hooks();
		}

		add_action( 'brandy_after_' . static::NICHE_ID . '_import_header', array( $this, 'after_import_header' ) );
		add_action( 'brandy_after_' . static::NICHE_ID . '_import_footer', array( $this, 'after_import_footer' ) );
	}

	/**
	 * Register hooks for the current niche.
	 *
	 * @return void
	 */
	protected function register_current_niche_hooks() {
		add_filter( 'wp_theme_json_data_theme', array( $this, 'update_theme_json' ) );
		add_filter( 'get_block_templates', array( $this, 'replace_templates' ), 10, 3 );
		add_filter( 'get_block_templates', array( $this, 'replace_template_parts' ), 10, 3 );
		add_filter( 'get_block_file_template', array( $this, 'replace_block_template_parts' ), 10, 3 );
		add_filter( 'brandy_default_header_settings', array( $this, 'merge_niche_data_to_default_settings' ), PHP_INT_MAX );
		add_filter( 'brandy_default_footer_settings', array( $this, 'merge_niche_data_to_default_footer' ), PHP_INT_MAX );
		add_filter( 'brandy_default_header_menu_styles', array( $this, 'get_default_header_menu_styles' ) );
		add_filter( 'brandy_product_demo_cats', array( static::class, 'get_demo_cats' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_niche_scripts' ) );
		add_filter( 'brandy_sites_query_product_layout', array( static::class, 'change_product_template' ) );
		add_filter( 'block_type_metadata_settings', array( $this, 'change_block_type_metadata_settings' ), 10, 2 );
		add_filter( 'brandy_blocks_slider_button_icon', array( $this, 'change_slider_icon' ), 10, 2 );
		add_action(
			'enqueue_block_assets',
			function () {
				global $current_screen;
				if ( ! empty( $current_screen->is_block_editor ) ) {
					$this->enqueue_niche_scripts();
				}
			}
		);
		$this->register_patterns();
		$this->register_block_styles();
	}

	/**
	 * Enqueue niche-specific scripts and styles.
	 *
	 * @return void
	 */
	public function enqueue_niche_scripts() {
		$style_path = static::ROOT_PATH . '/assets/style.css';
		
		if ( ! file_exists( $style_path ) ) {
			return;
		}

		wp_enqueue_style( 'brandy-' . static::NICHE_ID . '-style', static::ROOT_URL . '/assets/style.css', array(), time() );
	}

	/**
	 * Get niche data.
	 *
	 * @return array Niche data.
	 */
	public static function get_data() {
		return array(
			'id' => static::NICHE_ID,
			'name' => static::get_name(),
			'thumbnail' => static::get_thumbnail(),
			'demo_url' => static::get_demo_url(),
			'plan' => static::get_plan(),
			'tags' => static::get_tags(),
			'mode' => static::get_mode(),
			'supports' => static::get_supports(),
			'template_data' => [
				'woocommerce' => [
					'product_layout' => static::get_product_layout(),
					'product_thumb_size' => static::get_product_thumb_size(),
				],
				'headers' => static::get_header_templates(),
				'footers' => static::get_footer_templates(),
			],
			'sample_products' => static::get_sample_products(),
			'sample_product_category_images' => static::get_sample_product_category_images(),
			'sample_posts' => static::get_sample_posts(),
			'sample_pages' => static::get_sample_pages(),
			'sample_menus' => static::get_sample_menus(),
		);
	}

	/**
	 * Merge niche header data to default settings.
	 *
	 * @param array $data Default header settings.
	 * @return array Modified settings.
	 */
	public function merge_niche_data_to_default_settings( $data ) {
		$header_file = static::get_data()['template_data']['headers'][0] ?? '';
		
		if ( ! file_exists( $header_file ) ) {
			return $data;
		}
		
		$header_data = $this->load_json_file( $header_file );
		return $header_data ?: $data;
	}

	/**
	 * Merge niche footer data to default settings.
	 *
	 * @param array $data Default footer settings.
	 * @return array Modified settings.
	 */
	public function merge_niche_data_to_default_footer( $data ) {
		$footer_file = static::get_data()['template_data']['footers'][0] ?? '';
		
		if ( ! file_exists( $footer_file ) ) {
			return $data;
		}
		
		$footer_data = $this->load_json_file( $footer_file );
		return $footer_data ?: $data;
	}

	/**
	 * Handle actions after menu import.
	 *
	 * @param string $niche_id The niche identifier.
	 * @param array  $menus    Array of menus.
	 * @return void
	 */
	public function after_import_menus( $niche_id, $menus = array() ) {
		if ( static::NICHE_ID !== $niche_id ) {
			return;
		}
		
		$locations = get_nav_menu_locations();
		
		foreach ( $menus as $menu_info ) {
			if ( empty( $menu_info['locations'] ) ) {
				continue;
			}
			
			foreach ( $menu_info['locations'] as $location ) {
				$locations[ $location ] = $menu_info['id'];
			}
		}
		
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	/**
	 * Update theme.json with niche-specific settings.
	 *
	 * @param object $theme_json Theme JSON data.
	 * @return object Modified theme JSON data.
	 */
	public function update_theme_json( $theme_json ) {
		$niche_json_file = static::JSON_FILE;
		$niche_json_data = $this->load_json_file( $niche_json_file );
		
		if ( ! $niche_json_data ) {
			return $theme_json;
		}

		if ( empty( $niche_json_data['settings'] ) ) {
			$niche_json_data['settings'] = array();
		}
		
		if ( empty( $niche_json_data['settings']['color'] ) ) {
			$niche_json_data['settings']['color'] = array();
		}

		if ( empty( $niche_json_data['settings']['color']['palette'] ) ) {
			$niche_json_data['settings']['color']['palette'] = array();
		}

		$niche_json_data['settings']['color']['palette'] = $niche_json_data['settings']['color']['palette'] ?? [];

		foreach ( $this->get_palette() as $color ) {
			if ( ! in_array( $color['slug'], array_column( $niche_json_data['settings']['color']['palette'], 'slug' ), true ) ) {
				$niche_json_data['settings']['color']['palette'][] = $color;
			}
		}

		$button_settings = get_theme_mod( 'button_settings', ButtonSettingsSection::default_settings() );

		if ( ( $button_settings['type'] ?? 'default' ) !== 'default' && ! is_customize_preview() ) {

			$primary_color = $button_settings['primaryColor'] ?? 'var(--wp--preset--color--brandy-primary-text)';
			$primary_hover_color = $button_settings['primaryHoverColor'] ?? 'var(--wp--preset--color--brandy-primary-text)';
			$primary_text_color = $button_settings['primaryTextColor'] ?? 'var(--wp--preset--color--white)';
			$primary_text_hover_color = $button_settings['primaryTextHoverColor'] ?? 'var(--wp--preset--color--white)';

			$niche_json_data['styles']['elements']['button']['color']['text'] = $primary_text_color;
			$niche_json_data['styles']['elements']['button'][':hover']['color']['text'] = $primary_text_hover_color;
			$niche_json_data['styles']['elements']['button']['color']['background'] = $primary_color;
			$niche_json_data['styles']['elements']['button'][':hover']['color']['background'] = $primary_hover_color;

			$niche_json_data['styles']['blocks']['core/button']['variations']['outline']['color']['text'] = $primary_color;
			$niche_json_data['styles']['blocks']['core/button']['variations']['outline']['color']['background'] = "#ffffff00";
			$niche_json_data['styles']['blocks']['core/button']['variations']['outline']['css'] = "&:hover {color:{$primary_text_color};background:{$primary_color};border-color:{$primary_color};}";
		}

		
		return $theme_json->update_with( $niche_json_data );
	}

	/**
	 * Get the gray color palette.
	 *
	 * @return array Gray color palette.
	 */
	protected function get_palette() {
		return [
			array(
				'color' => '#272829',
				'slug'  => 'brandy-primary-text',
				'name'  => 'Brandy Primary Text'
			),
			array(
				'color' => '#5A6D80',
				'slug'  => 'brandy-secondary-text',
				'name'  => 'Brandy Secondary Text'
			),
			array(
				'color' => '#edf3f9',
				'slug'  => 'brandy-border',
				'name'  => 'Brandy Border'
			),
			array(
				'color' => '#FCFCFC',
				'slug'  => 'brandy-gray-1',
				'name'  => 'Brandy Gray 1'
			),
			array(
				'color' => '#FAFAFA',
				'slug'  => 'brandy-gray-2',
				'name'  => 'Brandy Gray 2'
			),
			array(
				'color' => '#F4F4F5',
				'slug'  => 'brandy-gray-3',
				'name'  => 'Brandy Gray 3'
			),
			array(
				'color' => '#E4E4E7',
				'slug'  => 'brandy-gray-4',
				'name'  => 'Brandy Gray 4'
			),
			array(
				'color' => '#E3E3E5',
				'slug'  => 'brandy-gray-5',
				'name'  => 'Brandy Gray 5'
			),
			array(
				'color' => '#C7C7CA',
				'slug'  => 'brandy-gray-6',
				'name'  => 'Brandy Gray 6'
			),
			array(
				'color' => '#A0A0A7',
				'slug'  => 'brandy-gray-7',
				'name'  => 'Brandy Gray 7'
			),
			array(
				'color' => '#7B7C80',
				'slug'  => 'brandy-gray-8',
				'name'  => 'Brandy Gray 8'
			),
			array(
				'color' => '#535357',
				'slug'  => 'brandy-gray-9',
				'name'  => 'Brandy Gray 9'
			)
		];
	}

	/**
	 * Check if the current niche is active.
	 *
	 * @return bool Whether the current niche is active.
	 */
	public static function is_current_niche() {
		return brandy_is_current_niche( static::NICHE_ID );
	}

	/**
	 * Handle actions after header import.
	 *
	 * @return void
	 */
	public function after_import_header() {
		$header_templates = static::get_header_templates();
		if ( isset( $header_templates['main'] ) && file_exists( $header_templates['main'] ) ) {
			$data = file_get_contents( $header_templates['main'] );
			$data = json_decode( $data, true );
			$this->update_main_header_template( $data['id'] );
		}

		if ( isset( $header_templates['checkout'] ) && file_exists( $header_templates['checkout'] ) ) {
			$data = file_get_contents( $header_templates['checkout'] );
			$data = json_decode( $data, true );
			HeaderTemplateMetaService::assign_meta_value( 
				brandy_get_checkout_page_id(), 
				$data['id'] 
			);
		}
	}

	/**
	 * Update main header template.
	 *
	 * @return void
	 */
	protected function update_main_header_template( $id ) {
		$builder_settings = brandy_get_header_settings();
		$builder_settings['current_template_id'] = $id;

		brandy_save_header_settings( $builder_settings );
	}

	/**
	 * Handle actions after footer import.
	 *
	 * @return void
	 */
	public function after_import_footer() {
		$footer_templates = static::get_footer_templates();
		if ( isset( $footer_templates['main'] ) && file_exists( $footer_templates['main'] ) ) {
			$data = file_get_contents( $footer_templates['main'] );
			$data = json_decode( $data, true );
			$this->update_main_footer_template( $data['id'] );
		}

		if ( isset( $footer_templates['checkout'] ) && file_exists( $footer_templates['checkout'] ) ) {
			$data = file_get_contents( $footer_templates['checkout'] );
			$data = json_decode( $data, true );
			FooterTemplateMetaService::assign_meta_value( 
				brandy_get_checkout_page_id(), 
				$data['id'] 
			);
		}
	}

	/**
	 * Update main footer template.
	 *
	 * @return void
	 */
	protected function update_main_footer_template( $id ) {
		$builder_settings = brandy_get_footer_settings();
		$builder_settings['current_template_id'] = $id;

		brandy_save_footer_settings( $builder_settings );
	}

	/**
	 * Register block patterns for the niche.
	 *
	 * @return void
	 */
	public function register_patterns() {
		$path_to_patterns = static::ROOT_PATH . '/patterns';
		
		if ( ! file_exists( $path_to_patterns ) ) {
			return;
		}

		$pattern_files = $this->get_directory_files( $path_to_patterns );
		
		foreach ( $pattern_files as $file_path ) {
			$this->register_single_pattern( $file_path );
		}
	}

	/**
	 * Register a single block pattern.
	 *
	 * @param string $file_path Path to the pattern file.
	 * @return void
	 */
	protected function register_single_pattern( $file_path ) {
		if ( ! file_exists( $file_path ) ) {
			return;
		}

		$file_info = pathinfo( $file_path );

		if ( 'php' !== $file_info['extension'] ) {
			return;
		}

		$pattern_info = $this->get_pattern_info( $file_path );
		
		if ( ! $this->should_register_pattern( $pattern_info ) ) {
			return;
		}

		$pattern_info['content'] = $this->get_pattern_content( $file_path );

		register_block_pattern(
			$pattern_info['slug'],
			$pattern_info
		);
	}

	/**
	 * Get pattern information from file header.
	 *
	 * @param string $file_path Path to pattern file.
	 * @return array Pattern information.
	 */
	protected function get_pattern_info( $file_path ) {
		$pattern_info = get_file_data(
			$file_path,
			array(
				'title'         => 'Title',
				'slug'          => 'Slug',
				'categories'    => 'Categories',
				'viewportWidth' => 'Viewport Width',
			)
		);

		if ( empty( $pattern_info['viewportWidth'] ) ) {
			$pattern_info['viewportWidth'] = 1500;
		}

		$pattern_info['categories'] = explode( ', ', $pattern_info['categories'] ?? '' );

		return $pattern_info;
	}

	/**
	 * Check if a pattern should be registered.
	 *
	 * @param array $pattern_info Pattern information.
	 * @return bool Whether the pattern should be registered.
	 */
	protected function should_register_pattern( $pattern_info ) {
		return ! ( 
			! is_wc_installed() && 
			is_array( $pattern_info['categories'] ) && 
			in_array( 'woocommerce', $pattern_info['categories'], true ) 
		);
	}

	/**
	 * Get pattern content from file.
	 *
	 * @param string $file_path Path to pattern file.
	 * @return string Pattern content.
	 */
	protected function get_pattern_content( $file_path ) {
		ob_start();
		require $file_path;
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}

	/**
	 * Get templates for the niche.
	 *
	 * @return array Templates.
	 */
	public static function get_templates() {
		$path_to_templates = static::ROOT_PATH . '/templates';
		
		if ( ! file_exists( $path_to_templates ) ) {
			return array();
		}

		$template_files = self::get_directory_files( $path_to_templates );
		$templates = array();
		
		foreach ( $template_files as $file_path ) {
			if ( ! file_exists( $file_path ) ) {
				continue;
			}

			$file_info = pathinfo( $file_path );
			$slug = basename( $file_info['basename'], '.html' );
			$templates[ $slug ] = $file_path;
		}

		return $templates;
	}

	/**
	 * Get template parts for the niche.
	 *
	 * @return array Template parts.
	 */
	public static function get_parts() {
		$path_to_parts = static::ROOT_PATH . '/parts';
		
		if ( ! file_exists( $path_to_parts ) ) {
			return array();
		}

		$part_files = self::get_directory_files( $path_to_parts );
		$parts = array();
		
		foreach ( $part_files as $file_path ) {
			if ( ! file_exists( $file_path ) ) {
				continue;
			}

			$file_info = pathinfo( $file_path );
			$slug = basename( $file_info['basename'], '.html' );
			$parts[ $slug ] = $file_path;
		}

		return $parts;
	}

	/**
	 * Get files from a directory.
	 *
	 * @param string $directory Path to directory.
	 * @return array Files in directory.
	 */
	protected static function get_directory_files( $directory ) {
		$dir = new \DirectoryIterator( $directory );
		$files = array();
		
		foreach ( $dir as $fileinfo ) {
			if ( ! $fileinfo->isDot() ) {
				$files[] = $fileinfo->getPath() . '/' . $fileinfo->getFilename();
			}
		}
		
		return $files;
	}

	/**
	 * Replace templates.
	 *
	 * @param array  $query_result  Query results.
	 * @param object $query         Query object.
	 * @param string $template_type Template type.
	 * @return array Modified query results.
	 */
	public function replace_templates( $query_result, $query, $template_type ) {
		if ( 'wp_template' !== $template_type ) {
			return $query_result;
		}

		$templates = self::get_templates();

		foreach ( $query_result as $index => $wp_block_template ) {
			if ( null !== $wp_block_template->wp_id ) {
				continue;
			}

			if ( ! in_array( $wp_block_template->slug, array_keys( $templates ), true ) ) {
				continue;
			}

			if ( ! file_exists( $templates[ $wp_block_template->slug ] ) ) {
				continue;
			}

			$query_result[ $index ]->content = $this->get_pattern_content( $templates[ $wp_block_template->slug ] );
		}

		return $query_result;
	}

	/**
	 * Replace template parts.
	 *
	 * @param array  $query_result  Query results.
	 * @param object $query         Query object.
	 * @param string $template_type Template type.
	 * @return array Modified query results.
	 */
	public function replace_template_parts( $query_result, $query, $template_type ) {
		if ( 'wp_template_part' !== $template_type ) {
			return $query_result;
		}

		$parts = self::get_parts();

		foreach ( $query_result as $index => $wp_block_template ) {
			if ( null !== $wp_block_template->wp_id ) {
				continue;
			}

			if ( ! isset( $wp_block_template->slug ) ) {
				continue;
			}

			if ( ! in_array( $wp_block_template->slug, array_keys( $parts ), true ) ) {
				continue;
			}

			if ( ! file_exists( $parts[ $wp_block_template->slug ] ) ) {
				continue;
			}

			$query_result[ $index ]->content = $this->get_pattern_content( $parts[ $wp_block_template->slug ] );
		}

		return $query_result;
	}

	/**
	 * Replace block template parts.
	 *
	 * @param object $block_template Block template.
	 * @param string $id            Template ID.
	 * @param string $template_type Template type.
	 * @return object Modified block template.
	 */
	public function replace_block_template_parts( $block_template, $id, $template_type ) {
		if ( 'wp_template_part' !== $template_type ) {
			return $block_template;
		}

		if ( ! isset( $block_template->slug ) ) {
			return $block_template;
		}

		$parts = self::get_parts();

		if ( ! in_array( $block_template->slug, array_keys( $parts ), true ) ) {
			return $block_template;
		}
		
		if ( ! file_exists( $parts[ $block_template->slug ] ) ) {
			return $block_template;
		}

		$block_template->content = $this->get_pattern_content( $parts[ $block_template->slug ] );

		return $block_template;
	}

	/**
	 * Get product categories file path.
	 *
	 * @return string File path.
	 */
	public static function get_product_cats_file() {
		return static::ROOT_PATH . '/sample-data/sample-product-category-images.json';
	}

	/**
	 * Get product categories query parameters.
	 *
	 * @return array Query parameters.
	 */
	public static function get_prod_cats_query_params() {
		$cats_file = static::get_product_cats_file();
		$cats_data = array();

		if ( file_exists( $cats_file ) ) {
			$cats_data = self::load_json_file( $cats_file ) ?: array();
		}

		return array(
			'taxonomy' => 'product_cat',
			'slug'     => array_keys( $cats_data ),
			'fields'   => 'ids',
		);
	}

	/**
	 * Get default header menu styles.
	 *
	 * @param array $styles Default styles.
	 * @return array Modified styles.
	 */
	public function get_default_header_menu_styles( $styles ) {
		$path_to_menu_styles = static::ROOT_PATH . '/sample-data/sample-header-menu-styles.json';
		
		if ( ! file_exists( $path_to_menu_styles ) ) {
			return $styles;
		}
		
		$menu_styles = $this->load_json_file( $path_to_menu_styles );
		return $menu_styles ?: $styles;
	}

	/**
	 * Change demo categories.
	 *
	 * @return array Demo categories.
	 */
	public static function get_demo_cats() {
		return get_terms( self::get_prod_cats_query_params() );
	}

	/**
	 * Load and decode a JSON file.
	 *
	 * @param string $file_path Path to JSON file.
	 * @return array|false Decoded JSON data or false on error.
	 */
	protected static function load_json_file( $file_path ) {
		if ( ! file_exists( $file_path ) ) {
			return false;
		}
		
		$file_content = file_get_contents( $file_path );
		
		if ( false === $file_content ) {
			return false;
		}
		
		$json_data = json_decode( $file_content, true );
		
		if ( null === $json_data && json_last_error() !== JSON_ERROR_NONE ) {
			return false;
		}
		
		return $json_data;
	}

	public static function get_name() {
		return static::NICHE_NAME;
	}

	public static function get_thumbnail() {
		return static::NICHE_THUMBNAIL;
	}

	public static function get_demo_url() {
		return static::NICHE_DEMO_URL;
	}

	public static function get_plan() {
		return static::NICHE_PLAN;
	}

	public static function get_tags() {
		return static::NICHE_TAGS;
	}

	public static function get_supports() {
		return static::NICHE_SUPPORTS;
	}

	public static function get_product_layout() {
		return static::NICHE_PRODUCT_LAYOUT;
	}
	
	public static function get_product_thumb_size() {
		return static::NICHE_PRODUCT_THUMB_SIZE;
	}

	public static function get_product_gallery_thumb_image_width() {
		return static::NICHE_PRODUCT_GALLERY_THUMB_IMAGE_WIDTH;
	}

	public static function get_product_gallery_thumb_image_height() {
		return static::NICHE_PRODUCT_GALLERY_THUMB_IMAGE_HEIGHT;
	}

	public static function get_sample_menus() {
		return array(
			static::get_primary_menu(),
			static::get_secondary_menu(),
		);
	}

	public static function get_primary_menu() {
		$menu_items = [];
		$menu_items[] = array(
			'title'       => __( 'Home', 'brandy' ),
			'status'      => 'publish',
			'object_id'   => brandy_get_home_page_id(),
			'item_object' => 'page',
			'item_type'   => 'post_type',
		);

		if ( \is_wc_installed() ) {
			$menu_items[] = array(
				'title'  => __( 'Products', 'brandy' ),
				'status' => 'publish',
				'object_id'   => brandy_get_shop_page_id(),
				'item_object' => 'page',
				'item_type'   => 'post_type',
				'key'         => 'shop',
			);
			$categories = self::get_demo_cats();
	
			if ( ! is_wp_error( $categories ) ) {
				foreach ( array_slice( $categories, 0, 6 ) as $cat_id ) {
					$cat             = get_term( $cat_id );
					$menu_items[] = array(
						'title'  => $cat->name,
						'status' => 'publish',
						'url'    => get_term_link( $cat_id, 'product_cat' ),
						'parent' => 'shop',
					);
				}
			}
		}

		$menu_items[] = array(
			'title'       => __( 'Blogs', 'brandy' ),
			'status'      => 'publish',
			'object_id'   => brandy_get_blog_page_id(),
			'item_object' => 'page',
			'item_type'   => 'post_type',
		);

		$menu_items[] = array(
			'title'       => __( 'About us', 'brandy' ),
			'status'      => 'publish',
			'object_id'   => brandy_get_about_us_page_id(),
			'item_object' => 'page',
			'item_type'   => 'post_type',
		);

		$menu_items[] = array(
			'title'       => __( 'Contact us', 'brandy' ),
			'status'      => 'publish',
			'object_id'   => brandy_get_contact_us_page_id(),
			'item_object' => 'page',
			'item_type'   => 'post_type',
		);

		$menu = array(
			'name'      => __( 'Primary menu', 'brandy' ),
			'locations' => array( 'primary-menu', 'header-menu-1' ),
			'items'     => $menu_items,
		);


		return $menu;
	}

	public static function get_secondary_menu() {
		return array(
			'name'  => __( 'Secondary menu', 'brandy' ),
			'items' => array(
				array(
					'title'       => __( 'Refund policy', 'brandy' ),
					'status'      => 'publish',
					'object_id'   => brandy_get_privacy_policy_page_id(),
					'item_object' => 'page',
					'item_type'   => 'post_type',
				),
				array(
					'title'       => __( 'Terms and conditions', 'brandy' ),
					'status'      => 'publish',
					'object_id'   => brandy_get_terms_and_conditions_page_id(),
					'item_object' => 'page',
					'item_type'   => 'post_type',
				),
				array(
					'title'       => __( 'About us', 'brandy' ),
					'status'      => 'publish',
					'object_id'   => brandy_get_about_us_page_id(),
					'item_object' => 'page',
					'item_type'   => 'post_type',
				),
				array(
					'title'       => __( 'Contact us', 'brandy' ),
					'status'      => 'publish',
					'object_id'   => \brandy_get_contact_us_page_id(),
					'item_object' => 'page',
					'item_type'   => 'post_type',
				),
			),
		);
	}
	
	public static function get_mode() {
		return static::NICHE_MODE;
	}

	public static function get_header_templates() {
		return array(
			'main' => static::ROOT_PATH . '/sample-data/sample-header.json',
			'checkout' => static::ROOT_PATH . '/sample-data/checkout-header.json',
		);
	}
	
	public static function get_footer_templates() {
		return array(
			'main' => static::ROOT_PATH . '/sample-data/sample-footer.json',
			'checkout' => static::ROOT_PATH . '/sample-data/checkout-footer.json',
		);
	}
	
	public static function get_sample_products() {
		return static::ROOT_PATH . '/sample-data/sample-products.csv';
	}
	
	public static function get_sample_product_category_images() {
		return static::ROOT_PATH . '/sample-data/sample-product-category-images.json';
	}
	
	
	public static function get_sample_posts() {
		return array(
			'gutenberg' => static::ROOT_PATH . '/sample-data/sample-posts.xml',
		);
	}
	
	public static function get_sample_pages() {
		return array(
			'gutenberg' => '',
		);
	}

	/**
	 * @deprecated Use change_product_template() instead.
	 */
	public function change_product_template_layout() {
		return '';
	}

	public static function change_product_template( $layout ) {

		if ( file_exists( static::ROOT_PATH . '/views/query-product-layout.php' ) ) {
			return static::ROOT_PATH . '/views/query-product-layout.php';
		}

		return $layout;
	}

	public function register_block_styles() {

		if ( file_exists( static::ROOT_PATH . '/assets/wc-product-categories.css' ) ) {
			wp_enqueue_block_style(
				'woocommerce/product-categories',
				array(
					'handle' => 'brandy/wc-product-categories',
					'src'    => static::ROOT_URL . '/assets/wc-product-categories.css',
					'ver'    => BRANDY_SCRIPT_VERSION,
				)
			);
		}

	}

	public function change_block_type_metadata_settings( $settings, $metadata ) {

		if ( ! file_exists( static::ROOT_PATH . '/views/product-categories-layout.php' ) ) {
			return $settings;
		}

		if ( 'woocommerce/product-categories' === $metadata['name'] ) {
			$settings['render_callback'] = array( $this, 'change_product_categories_layout' );
		}

		return $settings;
	}

	public function change_product_categories_layout( $attributes, $content ) {
		if ( ! file_exists( static::ROOT_PATH . '/views/product-categories-layout.php' ) ) {
			return $content;
		}

		ob_start();
		include static::ROOT_PATH . '/views/product-categories-layout.php';
		$content = ob_get_clean();

		return $content;
	}

	public function change_slider_icon( $icon, $type = 'prev' ) {
		if ( 'next' === $type ) {
			$next_icon = $this->slider_next_icon();
			return $next_icon ? $next_icon : $icon;
		}
		$prev_icon = $this->slider_prev_icon();
		return $prev_icon ? $prev_icon : $icon;
	}

	public function slider_prev_icon() {
		return '';
	}

	public function slider_next_icon() {
		return '';
	}
	
}