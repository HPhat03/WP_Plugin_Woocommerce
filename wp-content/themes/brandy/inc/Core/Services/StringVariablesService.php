<?php

namespace Brandy\Core\Services;

class StringVariablesService {

	/**
	 * Returns current year
	 *
	 * @return string current year
	 */
	public static function get_current_year() {
		return gmdate( 'Y' );
	}

	/**
	 * Returns Site Title
	 *
	 * @return string Site Title
	 */
	public static function get_site_title() {
		return get_bloginfo( 'name' );
	}

	/**
	 * Returns theme author
	 *
	 * @return string Theme author
	 */
	public static function get_theme_author() {
		$theme = wp_get_theme();
		return $theme->get( 'Author' );
	}

	public static function get_heart_icon() {
		return '&hearts;';
	}

	/**
	 * Get all data
	 */
	public static function get_data() {
		$data = self::map_with_functions();
		$result = array();
		foreach ( $data as $key => $function_data ) {
			$result[ $key ] = call_user_func( $function_data['function'], ...($function_data['args'] ?? []) );
		}
		return $result;
	}

	public static function map_with_functions() {
		return array(
			'current_year'        => [
				'function' => array( self::class, 'get_current_year' ),
			],
			'site_title'          => [
				'function' => array( self::class, 'get_site_title' ),
			],
			'theme_author'        => [
				'function' => array( self::class, 'get_theme_author' ),
			],
			'heart_icon'          => [
				'function' => array( self::class, 'get_heart_icon' ),
			],
			'shop_page_url'       => [
				'function' => 'brandy_get_shop_page_url',
			],
			'cart_page_url'         => [
				'function' => 'brandy_get_cart_page_url',
			],
			'checkout_page_url'     => [
				'function' => 'brandy_get_checkout_page_url',
			],	
			'blog_page_url'         => [
				'function' => 'brandy_get_blog_page_url',
			],
			'home_page_url'         => [
				'function' => 'home_url',
			],
			'login_url'             => [
				'function' => 'brandy_get_login_url',
			],
			'contact_us_page_url'   => [
				'function' => 'brandy_get_contact_us_page_url',
			],
			'about_us_page_url'     => [
				'function' => 'brandy_get_about_us_page_url',
			],
			'terms_page_url'        => [
				'function' => 'brandy_get_terms_and_conditions_page_url',
			],
			'privacy_page_url'      => [
				'function' => 'brandy_get_privacy_policy_page_url',
			],
			'my_account_page_url'   => [
				'function' => 'brandy_get_my_account_page_url',
			],
			'refund_returns_page_url' => [
				'function' => 'brandy_get_refund_returns_page_url',
			],
			'my_orders_page_url'      => [
				'function' => 'brandy_get_my_account_page_url',
				'args' => array( 'orders' ),
			],
			'my_wishlist_page_url'    => [
				'function' => 'brandy_get_my_account_page_url',
				'args' => array( 'wishlist' ),
			],
		);
	}

	public static function replace_variables( $content ) {
		$variables_with_functions = self::map_with_functions();
		foreach ( $variables_with_functions as $key => $function_data ) {
			$content = str_replace( "[$key]", call_user_func( $function_data['function'], ...($function_data['args'] ?? []) ), $content );
		}
		return $content;
	}

	public static function get_string_list_variables() {
		return implode( ', ', array_map(
			function( $variable_name ) {
				return "[$variable_name]";
			},
			array_keys( self::map_with_functions() )
		) );
	}
}
