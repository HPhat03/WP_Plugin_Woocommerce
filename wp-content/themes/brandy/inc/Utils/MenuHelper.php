<?php

namespace Brandy\Utils;

class MenuHelper {

	public static function get_locations() {
		return array_merge(
			self::get_main_locations(),
			self::get_header_locations(),
			self::get_footer_locations()
		);
	}

	public static function get_main_locations() {
		return array(
			'primary-menu'   => __( 'Primary Menu', 'brandy' ),
			'secondary-menu' => __( 'Secondary Menu', 'brandy' ),
		);
	}

	public static function get_header_locations() {
		return array(
			'header-menu-1' => __( 'Header Menu 1', 'brandy' ),
			'header-menu-2' => __( 'Header Menu 2', 'brandy' ),
		);
	}

	public static function get_footer_locations() {
		return array(
			'footer-menu-1' => __( 'Footer Menu 1', 'brandy' ),
			'footer-menu-2' => __( 'Footer Menu 2', 'brandy' ),
		);
	}

}
