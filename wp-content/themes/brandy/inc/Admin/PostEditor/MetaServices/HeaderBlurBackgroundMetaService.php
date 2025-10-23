<?php

namespace Brandy\Admin\PostEditor\MetaServices;

use Brandy\Abstracts\AbstractPostMetaService;
use Brandy\Admin\PostEditor\PostMetaServices;
use Brandy\Traits\SingletonTrait;

class HeaderBlurBackgroundMetaService extends AbstractPostMetaService {

	use SingletonTrait;

	public const META_NAME = '_brandy_post_header_blur_background';

	protected function __construct() {
		if ( ! is_admin() ) {
			add_action( 'brandy_print_global_css', array( $this, 'print_global_css' ) );
		}
	}

	public static function get_default_value() {
		return array(
			'type'  => 'inherit',
			'value' => 3,
		);
	}

	public function register_meta() {
		$args = array(
			'show_in_rest'  => array(
				'schema' => array(
					'type'       => 'object',
					'properties' => array(
						'type'  => array(
							'type' => 'string',
						),
						'value' => array(
							'type' => 'number',
						),
					),
				),
			),
			'single'        => true,
			'type'          => 'object',
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
		if ( empty( $meta_value['type'] ) ) {
			return false;
		}
		if ( null == $meta_value['value'] ) {
			return false;
		}
		return ! in_array( $meta_value['type'], array( 'inherit', 'custom' ), true );
	}

	public static function get_css_array() {
		$current_post_id = brandy_get_current_page_id();
		if ( empty( $current_post_id ) ) {
			return array();
		}

		$blur_background = self::get_value( $current_post_id );

		$styles = array();

		if ( isset( $blur_background['type'] ) && 'custom' === $blur_background['type'] ) {
			$styles['--brandy-header-sticky-blur-value'] = $blur_background['value'] . 'px';
		}

		return $styles;
	}

	public function print_global_css() { ?>
		<style id="brandy-post-meta-blur-background-styles">
			body.page-id-<?php echo esc_attr( brandy_get_current_page_id() ); ?> #brandy-header {
				<?php
					$css_variables = array_merge(
						self::get_css_array()
					);
					echo wp_kses_post( PostMetaServices::map_array_to_css( $css_variables ) );
				?>
			}
		</style>
		<?php
	}
}
