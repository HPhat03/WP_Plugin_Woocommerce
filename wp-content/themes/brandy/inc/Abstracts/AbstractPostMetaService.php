<?php

namespace Brandy\Abstracts;

abstract class AbstractPostMetaService {

	public const META_NAME = '';

	abstract public static function get_default_value();

	abstract public function register_meta();

	abstract public static function is_valid_meta_value( $meta_value );

	public static function get_value( $post_id ) {
		$meta_value = get_post_meta( $post_id, static::META_NAME, true );
		if ( is_null( $meta_value ) ) {
			return static::get_default_value();
		}
		return $meta_value;
	}

	public static function assign_meta_value( $post_id, $meta_value ) {
		if ( static::is_valid_meta_value( $meta_value ) ) {
			update_post_meta( $post_id, static::META_NAME, $meta_value );
		}
	}

}
