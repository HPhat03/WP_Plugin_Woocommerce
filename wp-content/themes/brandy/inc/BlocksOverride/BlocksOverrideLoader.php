<?php

namespace Brandy\BlocksOverride;

use Brandy\Traits\SingletonTrait;

/**
 * Override Gutenberg blocks
 */
class BlocksOverrideLoader {
	use SingletonTrait;

	protected function __construct() {
		$this->load_files();
		add_action( 'after_setup_theme', array( $this, 'add_style_for_blocks' ) );
		add_filter( 'block_type_metadata_settings', array( $this, 'change_blocks_metadata' ), 10, 2 );
	}

	public function add_style_for_blocks() {
		$styles = array(
			'woocommerce/product-categories'    => 'woocommerce-product-categories',
			'woocommerce/product-image-gallery' => 'woocommerce-product-image-gallery',
		);

		foreach ( $styles as $block_name => $handle ) {
			if ( ! file_exists( BRANDY_TEMPLATE_DIR . '/inc/BlocksOverride/Assets/' . $handle . '.css' ) ) {
				continue;
			}
			wp_enqueue_block_style(
				$block_name,
				array(
					'handle' => 'brandy/' . $handle,
					'src'    => BRANDY_TEMPLATE_URL . '/inc/BlocksOverride/Assets/' . $handle . '.css',
					'ver'    => BRANDY_SCRIPT_VERSION,
				)
			);
		}

	}

	public function load_files() {
		$platforms = array( 'Gutenberg', 'WooCommerce' );
		foreach ( $platforms as $platform ) {
			$dir  = new \DirectoryIterator( BRANDY_TEMPLATE_DIR . '/inc/BlocksOverride/' . $platform );
			$dirs = array();
			foreach ( $dir as $fileinfo ) {
				if ( ! $fileinfo->isDot() ) {
					$dirs[] = $fileinfo->getFilename();
				}
			}
			foreach ( $dirs as $file_name ) {
				$file_basename = basename( $file_name, '.php' );
				$class         = "Brandy\BlocksOverride\\$platform\\$file_basename";
				if ( ! class_exists( $class ) || ! is_callable( array( $class, 'get_instance' ) ) ) {
					continue;
				}

				call_user_func( array( $class, 'get_instance' ) );

			}
		}
	}

	public function change_blocks_metadata( $settings, $metadata ) {
		if ( ! isset( $metadata['name'] ) ) {
			return $settings;
		}

		if ( in_array(
			$metadata['name'],
			array(
				'woocommerce/order-confirmation-summary',
				'woocommerce/order-confirmation-totals',
				'woocommerce/order-confirmation-downloads',
				'woocommerce/order-confirmation-billing-address',
				'woocommerce/order-confirmation-shipping-address',
				'woocommerce/order-confirmation-additional-information',
			),
			true
		) ) {
			$settings['supports']['spacing']              = array(
				'margin'  => true,
				'padding' => true,
				'border'  => true,
			);
			$settings['supports']['shadow']               = true;
			$settings['supports']['__experimentalBorder'] = array(
				'color'                         => true,
				'radius'                        => true,
				'style'                         => true,
				'width'                         => true,
				'__experimentalDefaultControls' => array(
					'color'  => true,
					'radius' => true,
					'style'  => true,
					'width'  => true,
				),
			);
		}

		if ( 'woocommerce/order-confirmation-additional-information' === $metadata['name'] ) {
			$settings['supports']['color'] = array(
				'gradients'                     => true,
				'__experimentalDefaultControls' => array(
					'background' => true,
					'text'       => true,
				),
			);
		}

		return $settings;
	}
}

BlocksOverrideLoader::get_instance();
