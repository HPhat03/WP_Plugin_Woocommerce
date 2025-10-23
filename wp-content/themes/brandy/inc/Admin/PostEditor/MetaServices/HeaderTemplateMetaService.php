<?php

namespace Brandy\Admin\PostEditor\MetaServices;

use Brandy\Abstracts\AbstractPostMetaService;
use Brandy\Traits\SingletonTrait;

class HeaderTemplateMetaService extends AbstractPostMetaService {

	use SingletonTrait;

	public const META_NAME = '_brandy_post_header_template';

	public static function get_default_value() {
		return 'inherit';
	}

	public function register_meta() {
		$args = array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'default'       => self::get_default_value(),
			'auth_callback' => '__return_true',
		);

		foreach ( array( 'post', 'page' ) as $post_type ) {
			register_post_meta(
				$post_type,
				self::META_NAME,
				$args
			);
		}
	}

	public static function is_valid_meta_value( $meta_value ) {
		$settings     = brandy_get_header_settings();
		$templates    = $settings['templates'] ?? array();
		$templates_id = array_merge( array( 'inherit' ), array_column( $templates, 'id' ) );
		return in_array( $meta_value, $templates_id, true );
	}
}
