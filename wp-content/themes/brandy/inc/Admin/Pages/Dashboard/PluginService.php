<?php

namespace Brandy\Admin\Pages\Dashboard;

use Brandy\Traits\SingletonTrait;

class PluginService {
	use SingletonTrait;

	public static function get_required_plugins() {

		return self::mapped_plugins(
			array(
				'woocommerce'   => array(
					'slug'              => 'woocommerce',
					'name'              => 'WooCommerce',
					'short_name'        => 'Woo',
					'short_description' => __( 'Create an ecommerce website on WordPress.', 'brandy' ),
					'icon'              => 'https://ps.w.org/woocommerce/assets/icon.svg',
					'download_link'     => 'https://downloads.wordpress.org/plugin/woocommerce.zip',
					'url'               => 'https://wordpress.org/plugins/woocommerce',
					'version'           => 0,
					'groups'            => array( 'woocommerce' ),
				),
				'brandy_blocks' => array(
					'slug'              => 'brandy-blocks',
					'name'              => 'Brandy Blocks',
					'short_name'        => 'Brandy Blocks',
					'short_description' => __( 'Add custom ecommerce blocks to WordPress.', 'brandy' ),
					'icon'              => 'https://ps.w.org/brandy-blocks/assets/icon-256x256.png?rev=3095006',
					'download_link'     => 'https://downloads.wordpress.org/plugin/brandy-blocks.zip',
					'url'               => 'https://wordpress.org/plugins/brandy-blocks',
					'version'           => 0,
					'groups'            => array( 'woocommerce' ),
				),
			)
		);
	}

	public static function get_suggested_plugins() {

		return self::mapped_plugins(
			array(
				'brandy-sites'      => array(
					'slug'              => 'brandy-sites',
					'name'              => __( 'Brandy Starter Sites', 'brandy' ),
					'short_name'        => 'Brandy Starter Sites',
					'short_description' => __( 'Create stunning, professional websites.', 'brandy' ),
					'icon'              => 'https://ps.w.org/brandy-sites/assets/icon-256x256.png?rev=3125864',
					'download_link'     => 'https://downloads.wordpress.org/plugin/brandy-sites.zip',
					'url'               => 'https://wordpress.org/plugins/brandy-sites/',
					'version'           => 0,
					'groups'            => array( 'all', 'woocommerce' ),
				),
				'filebird'          => array(
					'slug'              => 'filebird',
					'name'              => __( 'FileBird - WordPress Media Library Folders & File Manager', 'brandy' ),
					'short_name'        => 'FileBird',
					'short_description' => __( 'Organize WP media library with folders.', 'brandy' ),
					'icon'              => 'https://ps.w.org/filebird/assets/icon-128x128.gif',
					'download_link'     => 'https://downloads.wordpress.org/plugin/filebird.zip',
					'url'               => 'https://wordpress.org/plugins/filebird/',
					'version'           => 0,
					'groups'            => array( 'management' ),
				),
				'filebird-document-library'          => array(
					'slug'              => 'filebird-document-library',
					'name'              => __( 'FileBird Document Library', 'brandy' ),
					'short_name'        => 'FileBird Documents',
					'short_description' => __( 'Create and publish document galleries.', 'brandy' ),
					'icon'              => 'https://ps.w.org/filebird-document-library/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/filebird-document-library.zip',
					'url'               => 'https://wordpress.org/plugins/filebird-document-library/',
					'version'           => 0,
					'groups'            => array( 'management' ),
				),
				'yaymail'           => array(
					'slug'              => 'yaymail',
					'name'              => __( 'YayMail - WooCommerce Email Customizer', 'brandy' ),
					'short_name'        => 'YayMail',
					'short_description' => __( 'Customize WooCommerce email templates.', 'brandy' ),
					'icon'              => 'https://ps.w.org/yaymail/assets/icon-256x256.gif',
					'download_link'     => 'https://downloads.wordpress.org/plugin/yaymail.zip',
					'url'               => 'https://wordpress.org/plugins/yaymail/',
					'version'           => 0,
					'groups'            => array( 'woocommerce', 'marketing' ),
				),
				'yaycurrency'       => array(
					'slug'              => 'yaycurrency',
					'name'              => __( 'YayCurrency - WooCommerce Multi-Currency Switcher', 'brandy' ),
					'short_name'        => 'YayCurrency',
					'short_description' => __( 'Add currency switcher with flags.', 'brandy' ),
					'icon'              => 'https://ps.w.org/yaycurrency/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/yaycurrency.zip',
					'url'               => 'https://wordpress.org/plugins/yaycurrency/',
					'version'           => 0,
					'groups'            => array( 'woocommerce', 'marketing' ),
				),
				'yaypricing'        => array(
					'slug'              => 'yaypricing',
					'name'              => __( 'YayPricing - WooCommerce Dynamic Pricing & Discounts', 'brandy' ),
					'short_name'        => 'YayPricing',
					'short_description' => __( 'Setup dynamic pricing & cart discounts.', 'brandy' ),
					'icon'              => 'https://ps.w.org/yaypricing/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/yaypricing.zip',
					'url'               => 'https://wordpress.org/plugins/yaypricing/',
					'version'           => 0,
					'groups'            => array( 'woocommerce', 'marketing' ),
				),
				'yayextra'          => array(
					'slug'              => 'yayextra',
					'name'              => __( 'YayExtra - WooCommerce Extra Product Options', 'brandy' ),
					'short_name'        => 'YayExtra',
					'short_description' => __( 'Add extra product options with custom fees.', 'brandy' ),
					'icon'              => 'https://ps.w.org/yayextra/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/yayextra.zip',
					'url'               => 'https://wordpress.org/plugins/yayextra/',
					'version'           => 0,
					'groups'            => array( 'woocommerce', 'marketing' ),
				),
				'yayswatches'       => array(
					'slug'              => 'yayswatches',
					'name'              => __( 'YaySwatches - Variation Swatches for WooCommerce', 'brandy' ),
					'short_name'        => 'YaySwatches',
					'short_description' => __( 'Display swatches on product page & shop page.', 'brandy' ),
					'icon'              => 'https://ps.w.org/yayswatches/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/yayswatches.zip',
					'url'               => 'https://wordpress.org/plugins/yayswatches/',
					'version'           => 0,
					'groups'            => array( 'woocommerce' ),
				),
				'yaysmtp'           => array(
					'slug'              => 'yaysmtp',
					'name'              => __( 'YaySMTP - Simple WP SMTP Mail', 'brandy' ),
					'short_name'        => 'YaySMTP',
					'short_description' => __( 'Send WordPress emails successfully.', 'brandy' ),
					'icon'              => 'https://ps.w.org/yaysmtp/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/yaysmtp.zip',
					'url'               => 'https://wordpress.org/plugins/yaysmtp/',
					'version'           => 0,
					'groups'            => array( 'marketing' ),
				),
				'yayreviews'           => array(
					'slug'              => 'yay-customer-reviews-woocommerce',
					'name'              => __( 'YayReviews - Customer Reviews for WooCommerce', 'brandy' ),
					'short_name'        => 'YayReviews',
					'short_description' => __( 'Advanced Customer Reviews for WooCommerce.', 'brandy' ),
					'icon'              => 'https://ps.w.org/yay-customer-reviews-woocommerce/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/yay-customer-reviews-woocommerce.zip',
					'url'               => 'https://wordpress.org/plugins/yay-customer-reviews-woocommerce/',
					'version'           => 0,
					'groups'            => array( 'woocommerce', 'marketing' ),
				),
				'wp-whatsapp'       => array(
					'slug'              => 'wp-whatsapp',
					'name'              => 'WP Chat App',
					'short_name'        => 'WhatsApp',
					'short_description' => __( 'Connect with customers on the go.', 'brandy' ),
					'icon'              => 'https://ps.w.org/wp-whatsapp/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/wp-whatsapp.zip',
					'url'               => 'https://wordpress.org/plugins/wp-whatsapp/',
					'version'           => 0,
					'groups'            => array( 'woocommerce', 'marketing' ),
				),
				'filester'          => array(
					'slug'              => 'filester',
					'name'              => __( 'Filester - File Manager Pro', 'brandy' ),
					'short_name'        => 'Filester',
					'short_description' => __( 'Manage WordPress files and configuration.', 'brandy' ),
					'icon'              => 'https://ps.w.org/filester/assets/icon-256x256.gif',
					'download_link'     => 'https://downloads.wordpress.org/plugin/filester.zip',
					'url'               => 'https://wordpress.org/plugins/filester/',
					'version'           => 0,
					'groups'            => array( 'management' ),
				),
				'cf7-multi-step'    => array(
					'slug'              => 'cf7-multi-step',
					'name'              => __( 'Multi Step for Contact Form 7', 'brandy' ),
					'short_name'        => 'Forms',
					'short_description' => __( 'Add multi-step to contact form 7.', 'brandy' ),
					'icon'              => 'https://ps.w.org/cf7-multi-step/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/cf7-multi-step.zip',
					'url'               => 'https://wordpress.org/plugins/cf7-multi-step/',
					'version'           => 0,
					'groups'            => array( 'marketing' ),
				),
				'cf7-database'      => array(
					'slug'              => 'cf7-database',
					'name'              => __( 'Database for Contact Form 7', 'brandy' ),
					'short_name'        => 'Forms',
					'short_description' => __( 'Save contact form 7 fields to database.', 'brandy' ),
					'icon'              => 'https://ps.w.org/cf7-database/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/cf7-database.zip',
					'url'               => 'https://wordpress.org/plugins/cf7-database/',
					'version'           => 0,
					'groups'            => array( 'management', 'marketing' ),
				),
				'wp-duplicate-page' => array(
					'slug'              => 'wp-duplicate-page',
					'name'              => __( 'WP Duplicate Page', 'brandy' ),
					'short_name'        => 'Post types',
					'short_description' => __( 'Duplicate page, post & custom post types.', 'brandy' ),
					'icon'              => 'https://ps.w.org/wp-duplicate-page/assets/icon-256x256.gif',
					'download_link'     => 'https://downloads.wordpress.org/plugin/wp-duplicate-page.zip',
					'url'               => 'https://wordpress.org/plugins/wp-duplicate-page/',
					'version'           => 0,
					'groups'            => array( 'management' ),
				),
				'notibar'           => array(
					'slug'              => 'notibar',
					'name'              => __( 'Notibar - Notification Bar for WordPress', 'brandy' ),
					'short_name'        => 'Notibar',
					'short_description' => __( 'Add top banner & announcement bar.', 'brandy' ),
					'icon'              => 'https://ps.w.org/notibar/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/notibar.zip',
					'url'               => 'https://wordpress.org/plugins/notibar/',
					'version'           => 0,
					'groups'            => array( 'marketing' ),
				),
				'fastdup'           => array(
					'slug'              => 'fastdup',
					'name'              => __( 'FastDup – Fastest WordPress Migration & Duplicator', 'brandy' ),
					'short_name'        => 'Fastdup',
					'short_description' => __( 'Backup and migrate your WordPress sites.', 'brandy' ),
					'icon'              => 'https://ps.w.org/fastdup/assets/icon-256x256.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/fastdup.zip',
					'url'               => 'https://wordpress.org/plugins/fastdup/',
					'version'           => 0,
					'groups'            => array( 'management' ),
				),
				'ninja-gdpr-compliance'          => array(
					'slug'              => 'ninja-gdpr-compliance',
					'name'              => __( 'GDPR CCPA Compliance & Cookie Consent Banner', 'brandy' ),
					'short_name'        => 'GDPR CCPA',
					'short_description' => __( 'Protect personal user data and privacy of EU citizens.', 'brandy' ),
					'icon'              => 'https://ps.w.org/ninja-gdpr-compliance/assets/icon-128x128.png',
					'download_link'     => 'https://downloads.wordpress.org/plugin/ninja-gdpr-compliance.zip',
					'url'               => 'https://wordpress.org/plugins/ninja-gdpr-compliance/',
					'version'           => 0,
					'groups'            => array( 'management' ),
				),
			)
		);
	}

	public static function get_active_plugins() {
		return apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
	}

	/**
	 * Map status and file dir to given plugins list
	 */
	private static function mapped_plugins( $plugins ) {

		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$active_plugins = self::get_active_plugins();

		$plugins = array_map(
			function( $p ) use ( $active_plugins ) {
				$slug     = $p['slug'];
				$pro_slug = $p['slug'] . '-pro';

				/**
				 * Check is activated plugin
				 */
				foreach ( $active_plugins as $active_plugin ) {
					if ( false !== strpos( $active_plugin, $slug ) || false !== strpos( $active_plugin, $pro_slug ) ) {
						$p['status'] = 'activated';
						return $p;
					}
				}

				/**
				 * Check is installed plugin
				 */
				$plugin_status     = install_plugin_install_status( $p );
				$pro_plugin_status = install_plugin_install_status(
					wp_parse_args(
						array(
							'slug' => $pro_slug,
						),
						$p
					)
				);
				$p['status']       = 'not_installed';
				if ( 'install' !== $plugin_status['status'] || 'install' !== $pro_plugin_status['status'] ) {
					$p['status'] = 'installed';
				}
				if ( 'newer_installed' === $plugin_status['status'] ) {
					$p['file'] = $plugin_status['file'];
				}
				if ( 'newer_installed' === $pro_plugin_status['status'] ) {
					$p['file'] = $pro_plugin_status['file'];
				}
				return $p;
			},
			$plugins
		);

		return $plugins;
	}

	public static function install_and_activate_plugin( $plugin ) {
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
		require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

		$plugin_status     = install_plugin_install_status(
			array(
				'slug'    => $plugin['slug'],
				'version' => $plugin['version'],
			)
		);
		$pro_plugin_status = install_plugin_install_status(
			array(
				'slug'    => $plugin['slug'] . '-pro',
				'version' => $plugin['version'],
			)
		);

		if ( 'install' === $plugin_status['status'] && 'install' === $pro_plugin_status['status'] ) {
			$skin     = new \WP_Ajax_Upgrader_Skin();
			$upgrader = new \Plugin_Upgrader( $skin );

			$result = $upgrader->install( $plugin['download_link'] );
			if ( is_wp_error( $result ) ) {
				throw new \Error( 'Install failed' );
			}

			$args        = array(
				'slug'   => $upgrader->result['destination_name'],
				'fields' => array(
					'short_description' => true,
					'icons'             => true,
					'banners'           => false,
					'added'             => false,
					'reviews'           => false,
					'sections'          => false,
					'requires'          => false,
					'rating'            => false,
					'ratings'           => false,
					'downloaded'        => false,
					'last_updated'      => false,
					'added'             => false,
					'tags'              => false,
					'compatibility'     => false,
					'homepage'          => false,
					'donate_link'       => false,
				),
			);
			$plugin_data = plugins_api( 'plugin_information', $args );
			if ( empty( $plugin_data ) || is_wp_error( $plugin_data ) ) {
				throw new \Error( __( 'Install failed', 'brandy' ) );
			}

			$install_status = install_plugin_install_status( $plugin_data );

			if ( is_wp_error( $install_status ) ) {
				throw new \Error( __( 'Install failed', 'brandy' ) );
			}

			$plugin_file = $install_status['file'];
		} else {
			if ( 'install' !== $plugin_status['status'] ) {
				$plugin_file = $plugin_status['file'];
			}
			if ( 'install' !== $pro_plugin_status['status'] ) {
				$plugin_file = $pro_plugin_status['file'];
			}
		}

		self::activate_plugin( $plugin_file );

	}

	public static function activate_plugin( $plugin_file ) {

		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
		require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

		$activate_status = activate_plugin( $plugin_file );

		if ( is_wp_error( $activate_status ) ) {
			throw new \Error( __( 'Activate failed', 'brandy' ) );
		}
	}

	public static function get_plugins_information() {
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$yaycommerce_plugins_api = plugins_api(
			'query_plugins',
			array(
				'search' => 'yaycommerce',
			)
		);

		if ( is_wp_error( $yaycommerce_plugins_api ) ) {
			$yaycommerce_plugins = array();
		} else {
			$yaycommerce_plugins = $yaycommerce_plugins_api->plugins;
		}

		$ninjateam_plugins_api = plugins_api(
			'query_plugins',
			array(
				'search' => 'ninjateam',
			)
		);

		if ( is_wp_error( $ninjateam_plugins_api ) ) {
			$ninjateam_plugins = array();
		} else {
			$ninjateam_plugins = $ninjateam_plugins_api->plugins;
		}

		$suggested_plugins_slugs = array_map(
			function( $item ) {
				return $item['slug'];
			},
			array_values( self::get_suggested_plugins() )
		);

		$result_plugins = array_filter(
			array_merge( $yaycommerce_plugins, $ninjateam_plugins ),
			function( $item ) use ( $suggested_plugins_slugs ) {
				return in_array( $item['slug'], $suggested_plugins_slugs, true );
			}
		);

		return array_values( $result_plugins );
	}

}
