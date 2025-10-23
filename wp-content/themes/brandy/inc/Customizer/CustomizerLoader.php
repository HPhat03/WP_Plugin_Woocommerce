<?php
/**
 * The CustomizerLoader class is responsible for loading and managing the customizer settings for the Brandy theme.
 *
 * @package Brandy/Customizer
 * @since 1.0.0
 */

namespace Brandy\Customizer;

use Brandy\Core\Services\BuilderService;
use Brandy\Core\Services\StringVariablesService;
use Brandy\Customizer\Elements\ElementsLoader;
use Brandy\Customizer\Layouts\FooterRowSettings;
use Brandy\Customizer\Layouts\FooterSettings;
use Brandy\Customizer\Layouts\HeaderRowSettings;
use Brandy\Customizer\Layouts\HeaderSettings;
use Brandy\Customizer\Layouts\ToggleOffCanvasSettings;
use Brandy\Customizer\Panels\FooterPanel;
use Brandy\Customizer\Panels\General\ButtonSettingsSection;
use Brandy\Customizer\Panels\General\GeneralPanel;
use Brandy\Customizer\Panels\HeaderPanel;
use Brandy\Customizer\Panels\WooCommerce\WooCommercePanel;
use Brandy\CustomizerVite;
use Brandy\I18n;
use Brandy\Niches\NicheLoader;
use Brandy\Traits\SingletonTrait;

/**
 * Declare class
 */
class CustomizerLoader {
	use SingletonTrait;

	/**
	 * Constructor
	 */
	protected function __construct() {

		$this->load_classes();

		add_action( 'customize_controls_print_scripts', array( $this, 'controls_enqueue_scripts' ) );
		add_action(
			'customize_save_after',
			function() {
				if ( ! isset( $_POST['nonce'] ) ) {
					return;
				}

				if ( ! wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'save-customize_' . wp_get_theme()->get_stylesheet() ) ) {
					return;
				}
				if ( isset( $_POST['header_settings'] ) ) {
					brandy_save_header_settings( json_decode( wp_unslash( $_POST['header_settings'] ), true ) );
				}
				if ( isset( $_POST['footer_settings'] ) ) {
					brandy_save_footer_settings( json_decode( wp_unslash( $_POST['footer_settings'] ), true ) );
				}
			}
		);

		add_filter(
			'gettext',
			function( $translation, $text ) {
				if ( 'Shift-click to edit this element.' === $text ) {
					return '';
				}
				return $translation;
			},
			PHP_INT_MAX,
			2
		);

		add_action( 'customize_register', array( $this, 'remove_unused_customizer_panel' ) );
	}

	private function load_classes() {
		/**
		 * Require partials process
		 */
		PartialsLoader::get_instance();

		/**
		 * Register panels.
		 */
		HeaderPanel::get_instance();
		FooterPanel::get_instance();
		GeneralPanel::get_instance();
		WooCommercePanel::get_instance();

		do_action( 'brandy_register_customizer_panels' );

		do_action( 'brandy_after_register_customizer_panels' );

		/**
		 * Require element process class
		 */
		ElementsLoader::get_instance();

		/**
		 * Require loading settings
		 */
		HeaderSettings::get_instance();
		HeaderRowSettings::get_instance();
		FooterSettings::get_instance();
		FooterRowSettings::get_instance();
		ToggleOffCanvasSettings::get_instance();
	}

	private function get_localize_data() {
		$exclude_pages = function_exists( 'wc_get_page_id' ) ? array(
			\wc_get_page_id( 'cart' ),
			\wc_get_page_id( 'checkout' ),
			\wc_get_page_id( 'myaccount' ),
		) : array();
		$pages         = get_pages(
			array(
				'post_type'   => 'page',
				'post_status' => 'publish,private,draft',
				'child_of'    => 0,
				'parent'      => -1,
				'exclude'     => $exclude_pages,
				'sort_order'  => 'asc',
				'sort_column' => 'post_title',
			)
		);
		$page_choices  = array(
			'' => array(
				'title' => __( 'No page set', 'brandy' ),//phpcs:ignore
				'link'  => '#',
			),
		)
		+ array_combine(
			array_map( 'strval', wp_list_pluck( $pages, 'ID' ) ),
			array_map(
				function( $p ) {
					return array(
						'title' => $p->post_title,
						'link'  => get_page_link( $p->ID ),
					);
				},
				$pages
			)
		);
		if ( function_exists( 'wc_get_products' ) ) {
			$sample_products = \wc_get_products( array( 'limit' => 1 ) );
		}

		$data = array(
			'ajax'              => array(
				'path'   => admin_url( 'admin-ajax.php' ),
				'nonces' => array(),
			),
			'rtl'               => is_rtl(),
			'paths'             => array(
				'nav_menu'               => admin_url( 'nav-menus.php' ),
				'wc_checkout_page'       => brandy_get_checkout_page_url(),
				'wc_cart_page'           => brandy_get_cart_page_url(),
				'wc_shop_page'           => brandy_get_shop_page_url(),
				'wc_single_product_page' => empty( $sample_products ) ? '#' : $sample_products[0]->get_permalink(),
				'yay_currency_manage'    => admin_url( 'admin.php?page=yay_currency' ),
			),
			'colors'            => array(
				'icon' => array(
					'normal' => BRANDY_ICON_COLOR_NORMAL,
				),
			),
			'content_variables' => StringVariablesService::get_data(),
			'pages'             => $page_choices,
			'i18n'              => I18n::get_translations(),
			'theme_settings'    => wp_get_global_settings(),
			'extra_panels'      => apply_filters( 'brandy_customizer_extra_panels', array() ),
			'defaults'          => array(),
			'others'            => array(
				'site_icon' => get_site_icon_url(),
				// 'execution_unique_id' => wp_unique_id(),
			),
			'wp_global_styles' => wp_get_global_styles(),
		);

		$default_header = apply_filters( 'brandy_default_header_settings', HeaderPanel::get_default_template() );
		if ( empty( $default_header['elements']['logo_1']['settings']['logo']['url'] ) ) {
			$default_header['elements']['logo_1']['settings']['logo']['url'] = get_site_icon_url();
		}
		$data['defaults']['header'] = $default_header;

		$default_footer = apply_filters( 'brandy_default_footer_settings', FooterPanel::get_default_template() );
		if ( empty( $default_footer['elements']['logo_2']['settings']['logo']['url'] ) ) {
			$default_footer['elements']['logo_2']['settings']['logo']['url'] = get_site_icon_url();
		}
		$data['defaults']['footer'] = $default_footer;

		return apply_filters( 'brandy_extra_localize', $data );
	}

	/**
	 * Enqueue scripts/styles for controller in customize page
	 */
	public function controls_enqueue_scripts() {
		// wp_enqueue_style( 'dashicons' );
		wp_enqueue_media();
		wp_enqueue_editor();
		if ( is_admin() ) {
			\_WP_Editors::print_default_editor_scripts();
		}
		wp_add_inline_script(
			'wp-customize-widgets',
			'var customizeWidgetInitialize = wp.customizeWidgets.initialize;' .
			'wp.customizeWidgets = {initialize: function (a, b) {
				window.brandyWidgetsEditorName = a
				window.brandyWidgetsBlockEditorSettings = b

				customizeWidgetInitialize(a, b)
			}}'
		);
		CustomizerVite::enqueue_vite( 'main.tsx', '3003' );
		wp_localize_script( 'module/brandy/main.tsx', 'brandyCustomizerData', $this->get_localize_data() );
		wp_localize_script(
			'module/brandy/main.tsx',
			'brandyHeaderPresets',
			HeaderPanel::get_preset_settings()
		);
		wp_localize_script(
			'module/brandy/main.tsx',
			'brandyFooterPresets',
			FooterPanel::get_preset_settings()
		);

		$all_niches    = NicheLoader::get_instance()->get_niches();
		$niche_headers = array();
		$niche_footers = array();
		foreach ( $all_niches as $niche ) {
			foreach ( $niche['template_data']['headers'] ?? array() as $header_file ) {
				if ( ! file_exists( $header_file ) ) {
					continue;
				}

				$template_data = json_decode( file_get_contents( $header_file ), true ); //phpcs:ignore
				$niche_headers[] = $template_data;
			}
			foreach ( $niche['template_data']['footers'] ?? array() as $footer_file ) {
				if ( ! file_exists( $footer_file ) ) {
					continue;
				}

				$template_data = json_decode( file_get_contents( $footer_file ), true ); //phpcs:ignore
				$niche_footers[] = $template_data;
			}
		}
		wp_localize_script(
			'module/brandy/main.tsx',
			'brandyNichesHeaders',
			$niche_headers
		);
		wp_localize_script(
			'module/brandy/main.tsx',
			'brandyNichesFooters',
			$niche_footers
		);
		$header_settings = brandy_get_header_settings();
		$footer_settings = brandy_get_footer_settings();
		wp_localize_script(
			'module/brandy/main.tsx',
			'brandyHeaderSettings',
			$header_settings
		);
		wp_localize_script(
			'module/brandy/main.tsx',
			'brandyFooterSettings',
			$footer_settings
		);
		wp_localize_script(
			'module/brandy/main.tsx',
			'brandySettingsLayouts',
			BuilderService::get_settings_layouts()
		);
		wp_localize_script(
			'module/brandy/main.tsx',
			'brandyDefaultHeaderStyles',
			apply_filters(
				'brandy_default_header_menu_styles',
				[]
			)
		);
		wp_localize_script(
			'module/brandy/main.tsx',
			'brandyElements',
			apply_filters( 'brandy_all_elements', array() )
		);
		brandy_update_unsaved_header_settings( $header_settings );
		brandy_update_unsaved_footer_settings( $footer_settings );
	}

	public function remove_unused_customizer_panel( $manager ) {
		$remove_sections = array( 'colors', 'header_image', 'background_image' );
		foreach ( $remove_sections as $section_id ) {
			$manager->remove_section( $section_id );
		}
	}

}

CustomizerLoader::get_instance();
