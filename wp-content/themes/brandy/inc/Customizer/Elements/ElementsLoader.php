<?php

namespace Brandy\Customizer\Elements;

use Brandy\Traits\SingletonTrait;
use Brandy\Utils\Helpers;

class ElementsLoader {
	use SingletonTrait;

	protected function __construct() {
		$dir  = new \DirectoryIterator( BRANDY_TEMPLATE_DIR . '/inc/Customizer/Elements' );
		$dirs = array();
		foreach ( $dir as $fileinfo ) {
			if ( ! $fileinfo->isDot() ) {
				$dirs[] = $fileinfo->getFilename();
			}
		}
		usort(
			$dirs,
			function( $a, $b ) {
				return strcmp( $a, $b );
			}
		);
		foreach ( $dirs as $file_name ) {
			$file_basename = basename( $file_name, '.php' );
			if ( strtolower( $file_basename ) === 'elementsloader' ) {
				continue;
			}
			$class = "Brandy\Customizer\Elements\\$file_basename";
			if ( ! class_exists( $class ) || ! is_callable( array( $class, 'get_instance' ) ) ) {
				continue;
			}

			call_user_func( array( $class, 'get_instance' ) );

		}
	}

	/**
	 * Returns default icon size
	 *
	 * @param array $args Value to parse
	 *
	 * @return array
	 */
	public static function get_default_icon_size( $args = array() ) {
		return wp_parse_args(
			$args,
			array(
				'unit'  => 'px',
				'value' => 30,
				'min'   => 10,
				'max'   => 100,
			)
		);
	}
}
