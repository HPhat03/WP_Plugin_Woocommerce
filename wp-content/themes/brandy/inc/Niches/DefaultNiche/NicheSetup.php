<?php

namespace Brandy\Niches\DefaultNiche;

use Brandy\Abstracts\AbstractNicheSetup;
use Brandy\Traits\SingletonTrait;

class NicheSetup extends AbstractNicheSetup {
	use SingletonTrait;

	public const NICHE_ID = 'default';

	public const ROOT_PATH = BRANDY_TEMPLATE_DIR . '/inc/Niches/DefaultNiche';

	public const ROOT_URL = BRANDY_TEMPLATE_URL . '/inc/Niches/DefaultNiche';

	protected const NICHE_NAME = 'Default';

	protected const JSON_FILE = BRANDY_TEMPLATE_DIR . '/styles/default.json';

	public static function get_sample_posts() {
		return array(
			'gutenberg' => static::ROOT_PATH . '/sample-data/sample-posts.json',
		);
	}

	public static function get_header_templates() {
		return array(
			'main' => BRANDY_TEMPLATE_DIR . '/inc/presets/Header/preset_default.json',
		);
	}
	
	public static function get_footer_templates() {
		return array(
			'main' => BRANDY_TEMPLATE_DIR . '/inc/presets/Footer/preset_default.json',
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

		$args = array(
			'name'           => 'sample-page',
			'posts_per_page' => 1,
			'post_type'      => 'page',
			'post_status'    => 'publish'
		);
	
		$sample_pages = get_posts($args);

		if ( ! empty( $sample_pages ) ) {
			$menu_items[] = array(
				'title'       => __( 'Sample page', 'brandy' ),
				'status'      => 'publish',
				'object_id'   => $sample_pages[0]->ID,
				'item_object' => 'page',
				'item_type'   => 'post_type'
			);
		}

		$menu = array(
			'name'      => __( 'Primary menu', 'brandy' ),
			'locations' => array( 'primary-menu', 'header-menu-1' ),
			'items'     => $menu_items,
		);


		return $menu;
	}

}
