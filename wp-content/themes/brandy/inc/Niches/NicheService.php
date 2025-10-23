<?php

namespace Brandy\Niches;

use Brandy\Admin\Pages\Dashboard\ImportService;
use Brandy\Core\Services\ButtonService;
use Brandy\Admin\PostEditor\PostMetaServices;
use Brandy\Core\Services\ProductCatalogService;
use Brandy\Niches\NicheLoader;
use Brandy\Utils\Helpers;

class NicheService {

	public $niches;

	/**
	 * Contains importing service;
	 *
	 * @var ImportService
	 */
	public $import_service;

	public $selected_niche;

	/**
	 * Contains PostMetaServices service
	 *
	 * @var PostMetaServices
	 */
	public $post_meta_services;

	public function __construct( $niche_id ) {

		$this->import_service     = ImportService::get_instance();
		$this->post_meta_services = PostMetaServices::get_instance();
		$this->niches             = NicheLoader::get_instance()->get_niches();
		$this->selected_niche     = NicheLoader::get_instance()->get_niche( $niche_id );

	}

	public function install_niche( array $allowed_content, $builder = 'gutenberg' ) {

		$result = array();

		if ( empty( $this->selected_niche ) ) {
			throw new \Error( 'Niche not found' );
		}

		update_option( 'brandy_current_niche', $this->selected_niche['id'] );

		if ( in_array( 'clean_data', $allowed_content, true ) ) {
			$this->clean_sample_data();
		}

		if ( in_array( 'posts', $allowed_content, true ) ) {
			$this->reset_data();
			$this->install_template();

			$result['posts'] = $this->import_posts( $builder );
		}

		if ( function_exists( 'wc_set_time_limit' ) && ( in_array( 'products', $allowed_content, true ) || in_array( 'product_categories', $allowed_content, true ) ) ) {
			\wc_set_time_limit( 0 );
		}

		if ( in_array( 'products', $allowed_content, true ) ) {
			$result['products'] = $this->import_sample_products();
		}

		if ( in_array( 'product_categories', $allowed_content, true ) ) {
			$result['products'] = $this->import_product_categories();
		}

		if ( in_array( 'pages', $allowed_content, true ) ) {
			$result['pages'] = $this->import_pages( $builder );
		}

		if ( in_array( 'menus', $allowed_content, true ) ) {
			$result['menus'] = $this->import_menus();
		}

		if ( in_array( 'widgets', $allowed_content, true ) ) {
			$result['imported_widgets'] = $this->import_widgets();
		}

		return $result;
	}

	private function install_template() {

		if ( empty( $this->selected_niche ) ) {
			return;
		}

		$niche_id = $this->selected_niche['id'];

		do_action( 'brandy_before_' . $niche_id . '_installing_template_settings' );

		if ( isset( $this->selected_niche['template_data'] ) ) {
			$this->override_template_settings( $this->selected_niche['template_data'] );
		}

		do_action( 'brandy_after_' . $niche_id . '_installing_template_settings' );
	}

	private function import_sample_products() {
		if ( empty( $this->selected_niche ) ) {
			return array();
		}

		if ( ! isset( $this->selected_niche['sample_products'] ) || ! file_exists( $this->selected_niche['sample_products'] ) ) {
			return array();
		}

		$csv_file = $this->selected_niche['sample_products'];

		if ( ! file_exists( $csv_file ) ) {
			return array();
		}

		$imported_products = $this->import_service::read_products_from_csv( $csv_file );

		return $imported_products;
	}

	private function import_product_categories() {
		if (empty($this->selected_niche)) {
			return array();
		}

		$this->update_existing_categories();
		$this->import_category_images();
		$this->add_sample_product_reviews();

		return true;
	}

	private function update_existing_categories() {
		$product_categories = get_terms(array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		));

		if (is_wp_error($product_categories)) {
			return;
		}

		foreach ($product_categories as $cat) {
			if (strpos($cat->slug, 'brandy-') === 0) {
				\wp_update_term(
					$cat->term_id,
					'product_cat',
					array(
						'name' => trim(str_replace('Brandy', '', $cat->name)),
					)
				);
			}
		}
	}

	private function import_category_images() {
		$category_images_file = $this->selected_niche['sample_product_category_images'] ?? '';
		if (!file_exists($category_images_file)) {
			return;
		}

		try {
			$images_data = json_decode(file_get_contents($category_images_file)) ?: array();
		} catch (\Error $error) {
			return;
		}

		foreach ($images_data as $cat_slug => $img_source) {
			$cat = get_term_by('slug', $cat_slug, 'product_cat');
			if (empty($cat) || empty($cat->term_id) || empty($img_source)) {
				continue;
			}

			if (!empty(\get_term_meta($cat->term_id, 'thumbnail_id'))) {
				continue;
			}

			try {
				$image_id = media_sideload_image($img_source, 0, '', 'id');
				if (!is_wp_error($image_id)) {
					\update_term_meta($cat->term_id, 'thumbnail_id', absint($image_id));
				}
			} catch (\Error $error) {
				continue;
			}
		}
	}

	private function add_sample_product_reviews() {
		$sample_ratings = array(
			array(
				'rate' => 4,
				'review' => __('Great product! It exceeded my expectations in quality and performance. The only downside is the packaging, which could be more eco-friendly.', 'brandy'),
			),
			array(
				'rate' => 3, 
				'review' => __('Decent product but not worth the price. It works as advertised, but I found similar options for less money. Customer service was helpful, though.', 'brandy'),
			),
			array(
				'rate' => 5,
				'review' => __('Absolutely love this product! It has made my daily routine so much easier. Highly recommend to anyone looking for reliability and efficiency.', 'brandy'),
			),
			array(
				'rate' => 4,
				'review' => __("Very good product overall. It's sturdy and performs well, but it took a bit longer to arrive than I expected. Still, I'd buy it again!", 'brandy'),
			),
			array(
				'rate' => 1,
				'review' => __("Disappointed with this product. It didn't work as promised, and I had issues with durability. Customer support was slow to respond, which made it worse.", 'brandy'),
			),
		);

		try {
			$product_ids = $this->get_tagged_product_ids();
			$this->add_reviews_to_products($product_ids, $sample_ratings);
		} catch (\Error $error) {
			return;
		}
	}

	private function get_tagged_product_ids() {
		$product_tags_ids = get_terms(array(
			'taxonomy' => 'product_tag',
			'search' => 'brandy-',
			'fields' => 'ids',
		));

		$query = new \WP_Query(array(
			'posts_per_page' => -1,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_tag',
					'field' => 'id', 
					'terms' => $product_tags_ids,
				),
			),
			'post_type' => 'product',
			'orderby' => 'title',
			'fields' => 'ids'
		));

		return $query->posts;
	}

	private function add_reviews_to_products($product_ids, $sample_ratings) {
		foreach ($product_ids as $id) {
			$random_rating_indexes = array_rand($sample_ratings, wp_rand(2, 4));
			foreach ($random_rating_indexes as $random_index) {
				if (empty($sample_ratings[$random_index])) {
					continue;
				}

				$rating_data = $sample_ratings[$random_index];
				$comment_id = wp_new_comment(array(
					'comment_post_ID' => $id,
					'comment_content' => $rating_data['review'],
					'comment_type' => 'review',
					'comment_approved' => true,
					'user_ID' => get_current_user_id(),
					'comment_author_email' => '',
					'comment_author' => wp_get_current_user()->display_name,
					'comment_author_url' => '#',
				));

				if ($comment_id && !is_wp_error($comment_id)) {
					add_comment_meta($comment_id, 'rating', $rating_data['rate'], true);
				}
			}
		}
	}

	private function import_posts( $builder = 'gutenberg' ) {
		if ( empty( $this->selected_niche ) ) {
			return array();
		}

		$niche_id = $this->selected_niche['id'];
		$sample_posts = $this->get_sample_posts( $builder );

		if ( empty( $sample_posts ) ) {
			return array();
		}

		do_action( 'brandy_before_import_posts', $niche_id, $sample_posts );

		$existing_posts = $this->get_existing_posts( $sample_posts );
		$existed_posts_name = wp_list_pluck( $existing_posts->posts, 'post_name' );

		$not_existed_posts = array_filter(
			$sample_posts,
			function( $post_info ) use ( $existed_posts_name ) {
				return ! in_array( $post_info['name'], $existed_posts_name, true );
			}
		);

		$inserted_posts = array();
		foreach ( $not_existed_posts as $post_info ) {
			$inserted_id = $this->insert_post( $post_info, $niche_id, $builder );
			if ( $inserted_id ) {
				$inserted_posts[] = $inserted_id;
			}
		}

		do_action( 'brandy_after_import_posts', $niche_id, $inserted_posts );

		return $inserted_posts;
	}

	private function get_sample_posts( $builder ) {
		if ( ! isset( $this->selected_niche['sample_posts'][ $builder ] ) || 
			 ! file_exists( $this->selected_niche['sample_posts'][ $builder ] ) ) {
			return array();
		}

		$csv_file = $this->selected_niche['sample_posts'][ $builder ];
		return $this->import_service::read_posts_from_csv( $csv_file );
	}

	private function get_existing_posts( $sample_posts ) {
		return new \WP_Query(
			array(
				'post_type'     => 'post',
				'post_name__in' => array_map(
					function( $p ) {
						return $p['name'];
					},
					$sample_posts
				),
			)
		);
	}

	private function insert_post( $post_info, $niche_id, $builder ) {
		$comment_status = isset( $post_info['comment_status'] ) ? 
			( empty( $post_info['comment_status'] ) ? 'closed' : 'open' ) : 'open';
		$comments = isset( $post_info['comments'] ) ? $post_info['comments'] : array();

		$post_args = array(
			'post_title'     => $post_info['title'],
			'post_type'      => 'post', 
			'post_name'      => $post_info['name'],
			'post_content'   => $post_info['content'],
			'post_category'  => $post_info['post_category'],
			'tags_input'     => $post_info['tags_input'],
			'post_status'    => 'publish',
			'comment_status' => $comment_status,
			'ping_status'    => 'closed',
			'post_author'    => 1,
			'menu_order'     => 0
		);

		$inserted_id = wp_insert_post( $post_args );

		if ( 0 === $inserted_id || is_wp_error( $inserted_id ) ) {
			return false;
		}

		$this->add_post_meta( $inserted_id, $post_info['post_meta'] );
		$this->add_comments( $inserted_id, $comments );

		do_action( 'brandy_after_import_post', $niche_id, $builder, $inserted_id, $post_info );

		$this->import_service::add_featured_image( 
			$inserted_id, 
			$post_info['featured_image'] ?? '', 
			$post_info['name'] ?? '' 
		);

		return $inserted_id;
	}

	private function add_post_meta( $post_id, $post_meta ) {
		if ( empty( $post_meta ) ) {
			return;
		}

		foreach ( $post_meta as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}
	}

	private function add_comments( $post_id, $comments ) {
		foreach ( $comments as $comment ) {
			wp_insert_comment(
				array(
					'comment_post_ID' => $post_id,
					'comment_content' => $comment,
				)
			);
		}
	}

	private function import_pages( $builder = 'gutenberg' ) {
		if ( empty( $this->selected_niche ) ) {
			return array();
		}

		$niche_id = $this->selected_niche['id'];
		$imported_pages = array();
		$inserted_pages = array();

		// Get and merge sample pages from default and niche-specific sources
		$sample_pages = $this->get_merged_sample_pages( $builder );

		if ( empty( $sample_pages ) ) {
			return array();
		}

		do_action( 'brandy_before_import_pages', $niche_id, $sample_pages );

		// Get existing pages to avoid duplicates
		$existing_pages = $this->get_existing_pages( $sample_pages );
		$existed_pages_name = wp_list_pluck( $existing_pages->posts, 'post_name' );

		// Import existing pages
		if ( $existing_pages->have_posts() ) {
			$imported_pages = $this->process_existing_pages( $existing_pages->posts, $sample_pages );
		}

		// Import new pages
		$not_existed_pages = array_filter(
			$sample_pages,
			function( $page_info ) use ( $existed_pages_name ) {
				return ! in_array( $page_info['name'], $existed_pages_name, true );
			}
		);

		foreach ( $not_existed_pages as $page_info ) {
			$new_post_id = $this->insert_new_page( $page_info, $niche_id, $builder );
			
			if ( $new_post_id ) {
				$inserted_pages[] = $new_post_id;
				$imported_pages[] = array(
					'id'        => $new_post_id,
					'title'     => $page_info['title'],
					'name'      => $page_info['name'],
					'post_meta' => $page_info['post_meta'] ?? array(),
				);
			}
		}

		// Update page settings and metadata
		$this->update_page_settings( $imported_pages, $sample_pages );

		do_action( 'brandy_after_import_pages', $niche_id, $imported_pages );

		return $inserted_pages;
	}

	private function get_merged_sample_pages( $builder ) {
		// Get default sample pages
		$sample_pages = $this->import_service::read_posts_from_csv( 
			BRANDY_TEMPLATE_DIR . '/assets/sample-data/sample-pages.json'
		);

		// Filter out WooCommerce pages if not installed
		$sample_pages = array_filter( $sample_pages, function( $page ) {
			return ! ( ! empty( $page['dependency'] ) && 'wc' === $page['dependency'] && ! is_wc_installed() );
		} );

		// Merge with niche-specific pages
		if ( isset( $this->selected_niche['sample_pages'][ $builder ] ) ) {
			$niche_file = $this->selected_niche['sample_pages'][ $builder ];
			if ( file_exists( $niche_file ) ) {
				$niche_pages = $this->import_service::read_posts_from_csv( $niche_file );
				$sample_pages = $this->merge_unique_pages( $sample_pages, $niche_pages );
			}
		}

		return $sample_pages;
	}

	private function get_existing_pages( $sample_pages ) {

		$should_check_pages = array_filter( $sample_pages, function( $page ) {
			if ( isset( $page['dependency'] ) && 'wc' === $page['dependency'] ) {
				return is_wc_installed();
			}
			return true;
		} );

		return new \WP_Query( array(
			'post_type'     => 'page',
			'post_status'   => ['publish', 'draft'],
			'post_name__in' => wp_list_pluck( $should_check_pages, 'name' ),
			'no_found_rows' => true,
			'fields'        => 'all',
			'posts_per_page'=> 12 //Currently is number of pages in sample-pages.json
		) );
	}

	private function process_existing_pages( $posts, $sample_pages ) {
		$imported_pages = array();
		foreach ( $posts as $post ) {
			$matching_page = current( array_filter(
				$sample_pages,
				function( $item ) use ( $post ) {
					return $post->post_name === $item['name'];
				}
			) );

			$imported_pages[] = array(
				'id'        => $post->ID,
				'name'      => $post->post_name,
				'title'     => $post->post_title,
				'post_meta' => $matching_page['post_meta'] ?? array(),
			);
		}
		return $imported_pages;
	}

	private function insert_new_page( $page_info, $niche_id, $builder ) {
		$post_args = array_merge(
			array(
				'post_title'     => $page_info['title'],
				'post_type'      => 'page', 
				'post_name'      => $page_info['name'],
				'post_content'   => $page_info['content'],
				'post_status'    => 'publish',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_author'    => 1,
				'menu_order'     => 0,
			),
			isset( $page_info['page_template'] ) ? array(
				'page_template' => $page_info['page_template'],
			) : array()
		);

		$new_post_id = wp_insert_post( $post_args );

		if ( ! is_wp_error( $new_post_id ) && $new_post_id ) {
			do_action( 'brandy_after_import_page', $niche_id, $builder, $new_post_id, $page_info );
			return $new_post_id;
		}

		return false;
	}

	private function update_page_settings( $imported_pages, $sample_pages ) {
		$page_options = array(
			'homepage' => 'page_on_front',
			'blog' => 'page_for_posts',
			'terms-and-conditions' => 'woocommerce_terms_page_id',
			'privacy-policy' => 'wp_page_for_privacy_policy', 
			'shop' => 'woocommerce_shop_page_id',
			'cart' => 'woocommerce_cart_page_id',
			'checkout' => 'woocommerce_checkout_page_id'
		);

		foreach ( $imported_pages as $data ) {
			$page_info = current( array_filter(
				$sample_pages,
				function( $item ) use ( $data ) {
					return $item['name'] === $data['name'];
				}
			) );

			if ( empty( $page_info ) ) {
				continue;
			}

			$post_id = $data['id'];

			// Update special page options
			if ( ! empty( $page_info['name'] ) ) {
				if ( isset( $page_options[ $page_info['name'] ] ) ) {
					if ( in_array( $page_info['name'], array( 'homepage', 'blog' ) ) ) {
						update_option( 'show_on_front', 'page' );
					}
					update_option( $page_options[ $page_info['name'] ], $post_id );
				}
			}

			// Update post status and template
			wp_update_post( array_merge(
				array(
					'ID' => $post_id,
					'post_status' => 'publish',
				),
				! empty( $page_info['page_template'] ) ? array(
					'page_template' => $page_info['page_template'],
				) : array()
			) );

			// Update post meta
			$this->update_page_meta( $post_id, $page_info );
		}
	}

	private function update_page_meta( $post_id, $page_info ) {
		// Clear existing meta
		foreach ( ( $this->post_meta_services->services ?? array() ) as $meta_service ) {
			delete_post_meta( $post_id, $meta_service::META_NAME );
		}

		// Add new meta
		if ( ! empty( $page_info['post_meta'] ) ) {
			foreach ( $page_info['post_meta'] as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}

	private function merge_unique_pages( $sample_pages, $niche_pages ) {
		foreach ( $niche_pages as $page ) {
			if ( ! $this->page_exists( $sample_pages, $page['name'] ) ) {
				$sample_pages[] = $page;
			}
		}
		return $sample_pages;
	}

	private function page_exists( $pages, $name ) {
		return (bool) array_filter( $pages, function( $p ) use ( $name ) {
			return $p['name'] === $name;
		});
	}

	private function import_menus() {
		if (empty($this->selected_niche)) {
			return;
		}

		$niche_id = $this->selected_niche['id'];
		$sample_menus = $this->get_sample_menus();

		if (empty($sample_menus)) {
			return array();
		}

		do_action('brandy_before_import_menus', $niche_id, $sample_menus);

		$imported_menus = array();
		foreach ($sample_menus as $menu_info) {
			$menu_id = $this->create_or_get_menu($menu_info);
			if (!$menu_id) {
				continue;
			}

			$imported_menus[] = array_merge(
				array('id' => $menu_id),
				$menu_info
			);

			$parent_menus = $this->add_top_level_menu_items($menu_id, $menu_info['items']);
			$this->add_submenu_items($menu_id, $menu_info['items'], $parent_menus);
		}

		do_action('brandy_after_import_menus', $niche_id, $imported_menus);

		return $imported_menus;
	}

	private function get_sample_menus() {
		if (!isset($this->selected_niche['sample_menus']) || !is_array($this->selected_niche['sample_menus'])) {
			return array();
		}

		$niche_instance = NicheLoader::get_instance()->get_niche_instance($this->selected_niche['id']);

		if (!empty($niche_instance) && is_callable(array($niche_instance, 'get_sample_menus'))) {
			return $niche_instance::get_sample_menus();
		}

		return $this->selected_niche['sample_menus'];
	}

	private function create_or_get_menu($menu_info) {
		$existing_menu = wp_get_nav_menu_object($menu_info['name']);
		if ($existing_menu) {
			return $existing_menu->term_id;
		}

		$menu_id = wp_create_nav_menu($menu_info['name']);
		return is_wp_error($menu_id) ? false : $menu_id;
	}

	private function add_top_level_menu_items($menu_id, $items) {
		$parent_menus = array();

		foreach ($items as $menu_item) {
			if (isset($menu_item['parent'])) {
				continue;
			}

			$menu_args = $this->get_menu_item_args($menu_item);
			$id = wp_update_nav_menu_item($menu_id, 0, $menu_args);

			if (!is_wp_error($id) && !empty($menu_item['key'])) {
				$parent_menus[$menu_item['key']] = $id;
			}
		}

		return $parent_menus;
	}

	private function add_submenu_items($menu_id, $items, $parent_menus) {
		foreach ($items as $submenu) {
			if (!isset($submenu['parent']) || !isset($parent_menus[$submenu['parent']])) {
				continue;
			}

			$menu_args = $this->get_menu_item_args($submenu, $parent_menus[$submenu['parent']]);
			wp_update_nav_menu_item($menu_id, 0, $menu_args);
		}
	}

	private function get_menu_item_args($item, $parent_id = 0) {
		$base_args = array(
			'menu-item-title' => $item['title'] ?? 'Sample item',
			'menu-item-status' => $item['status'] ?? 'publish'
		);

		if (!empty($parent_id)) {
			$base_args['menu-item-parent-id'] = $parent_id;
		}

		if (empty($item['object_id'])) {
			return array_merge($base_args, array(
				'menu-item-url' => $item['url'] ?? '#'
			));
		}

		return array_merge($base_args, array(
			'menu-item-type' => $item['item_type'] ?? '',
			'menu-item-object-id' => $item['object_id'],
			'menu-item-object' => $item['item_object']
		));
	}

	private function import_widgets() {
		if ( empty( $this->selected_niche ) ) {
			return;
		}
		update_option( 'brandy_sample_widgets', $this->selected_niche['id'] );
	}

	private function override_template_settings( $data ) {
		/**
		 * Override button
		 */
		$button_settings = ButtonService::get_default_settings();
		if ( isset( $data['button'] ) ) {
			$button_settings = Helpers::recursive_wp_parse_args( $data['button'], $button_settings );
		}
		$this->override_button_settings( $button_settings );

		/**
		 * Override woocommerce
		 */
		$woocommerce_settings = array(
			'product_layout'     => 'option_1',
			'product_thumb_size' => 'size_1',
		);
		if ( isset( $data['woocommerce'] ) ) {
			$woocommerce_settings = Helpers::recursive_wp_parse_args( $data['woocommerce'], $woocommerce_settings );
		}
		$this->override_woocommerce_settings( $woocommerce_settings );

		/**
		 * Override builder settings
		 */
		if ( isset( $data['headers'] ) ) {
			$this->override_builder_settings( $data['headers'], 'header' );
		}

		if ( isset( $data['footers'] ) ) {
			$this->override_builder_settings( $data['footers'], 'footer' );
		}
	}

	private function override_button_settings( $data ) {
		ButtonService::save_settings( $data );
	}

	private function override_builder_settings( $files, $builder = 'header' ) {

		if ( empty( $this->selected_niche ) ) {
			return;
		}

		$niche_id = $this->selected_niche['id'];

		$fn = "brandy_get_{$builder}_settings";

		if ( ! is_callable( $fn ) ) {
			return;
		}

		$builder_settings = call_user_func( $fn );
		$templates        = &$builder_settings['templates'];
		$imported_data    = array();
		$main_data = [];

		foreach ( $files as $index => $file ) {
			if ( ! file_exists( $file ) ) {
				continue;
			}

			$template_data = json_decode( file_get_contents( $file ), true ); //phpcs:ignore

			if ( $index === 'main' ) {
				$main_data = $template_data;
			}

			if ( $index !== 'main' && $main_data ) {
				$template_data = Helpers::recursive_wp_parse_args( $template_data, $main_data );
			}

			$template_exists = false;

			foreach ( $templates as $index => $template ) {
				if ( $template_data['id'] === $template['id'] ) {
					$template_exists                         = true;
					$builder_settings['templates'][ $index ] = $template_data;
					break;
				}
			}

			if ( ! $template_exists ) {
				$builder_settings['templates'][] = $template_data;
			}

			$imported_data[] = $template_data;
		}

		$save_function = "brandy_save_{$builder}_settings";

		if ( is_callable( $save_function ) ) {
			call_user_func( $save_function, $builder_settings );

			do_action( "brandy_after_{$niche_id}_import_{$builder}", $imported_data );
		}
	}

	private function override_woocommerce_settings( $data ) {
		$product_catalog_data = array();
		if ( isset( $data['product_layout'] ) ) {
			$product_catalog_data['product_layout'] = $data['product_layout'];
		}
		if ( isset( $data['product_thumb_size'] ) ) {
			$product_catalog_data['product_thumb_size'] = $data['product_thumb_size'];
		}

		ProductCatalogService::save_settings( $product_catalog_data );

	}

	public function reset_wp_templates() {

		$post_names = array();

		$dir = new \DirectoryIterator( BRANDY_TEMPLATE_DIR . '/templates' );
		foreach ( $dir as $fileinfo ) {
			if ( ! $fileinfo->isDot() ) {
				$post_names[] = basename( $fileinfo->getFilename(), '.html' );
			}
		}
		$dir = new \DirectoryIterator( BRANDY_TEMPLATE_DIR . '/parts' );
		foreach ( $dir as $fileinfo ) {
			if ( ! $fileinfo->isDot() ) {
				$post_names[] = basename( $fileinfo->getFilename(), '.html' );
			}
		}
		$args  = array(
			'post_type'     => array( 'wp_template', 'wp_template_part' ),
			'post_name__in' => $post_names,
		);
		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return;
		}

		foreach ( $query->posts as $post ) {
			wp_delete_post( $post->ID );
		}
	}

	public function reset_editor_settings() {

		if ( ! class_exists( 'WP_Theme_JSON_Resolver' ) ) {
			return;
		}

		$id = \WP_Theme_JSON_Resolver::get_user_global_styles_post_id();

		if ( empty( $id ) ) {
			return;
		}

		if ( ! class_exists( 'WP_REST_Global_Styles_Controller' ) ) {
			return;
		}

		try {

			wp_update_post(
				array(
					'ID'           => $id,
					'post_content' => '{"isGlobalStylesUserThemeJSON":true,"version":3}',
				)
			);

		} catch ( \WP_Error $error ) {
			$trick_mode = 1;
			// This is silent
		} catch ( \Exception $exp ) {
			$trick_mode = 1;
			// This is silent
		}

	}

	public function clean_sample_data() {

		global $wpdb;

		/**
		 * Cleaning headers/footers
		 */
		// if ( ! empty( $this->selected_niche ) ) {
		// 	$header_settings              = brandy_get_header_settings();
		// 	$footer_settings              = brandy_get_footer_settings();
		// 	$header_settings['templates'] = array_values(
		// 		array_filter(
		// 			$header_settings['templates'],
		// 			function( $template ) {
		// 				return ( false === strpos( $template['id'], '_main_header' ) && false === strpos( $template['id'], '_checkout_header' ) );
		// 			}
		// 		)
		// 	);
		// 	$footer_settings['templates'] = array_values(
		// 		array_filter(
		// 			$footer_settings['templates'],
		// 			function( $template ) {
		// 				return ( false === strpos( $template['id'], '_main_footer' ) && false === strpos( $template['id'], '_checkout_footer' ) );
		// 			}
		// 		)
		// 	);
		// 	brandy_save_header_settings( $header_settings );
		// 	brandy_save_footer_settings( $footer_settings );
		// }

		/**
		 * Cleaning posts
		 */
		$posts_query = new \WP_Query(
			array(
				'posts_per_page' => -1,
				'tag'            => 'brandy-demo',
				'fields'         => 'ids',
			)
		);

		if ( $posts_query->have_posts() ) {
			foreach ( $posts_query->get_posts() as $post_id ) {
				wp_delete_post( $post_id, true );
			}
		}

		/**
		 * Cleaning sample products
		 */
		$product_tags_ids = get_terms(
			array(
				'taxonomy' => 'product_tag',
				'search'   => 'brandy-',
				'fields'   => 'ids',
			)
		);
		$product_cats_ids = get_terms(
			array(
				'taxonomy' => 'product_cat',
				'search'   => 'brandy-',
				'fields'   => 'ids',
			)
		);
		$post_cats_ids    = get_terms(
			array(
				'taxonomy'   => 'category',
				'search'     => 'brandy-',
				'hide_empty' => false,
				'fields'     => 'ids',
			)
		);

		$args          = array(
			'posts_per_page' => -1,
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_tag',
					'field'    => 'id',
					'terms'    => $product_tags_ids,
				),
			),
			'post_type'      => 'product',
			'orderby'        => 'title,',
		);
		$product_query = new \WP_Query( $args );

		if ( $product_query->have_posts() ) {
			foreach ( $product_query->get_posts() as $post ) {
				$product = \wc_get_product( $post );
				$product->delete( true );
				$product_cats_ids = array_merge( $product_cats_ids, $product->get_category_ids() );
			}
		}

		foreach ( array_unique( $product_cats_ids ) as $cat ) {
			wp_delete_term( $cat, 'product_cat' );
		}

		foreach ( array_unique( $post_cats_ids ) as $cat ) {
			wp_delete_term( $cat, 'category' );
		}

		foreach ( array_unique( $product_tags_ids ) as $tag ) {
			wp_delete_term( $tag, 'product_tag' );
		}

		/** Clean menus */
		if ( empty( $this->selected_niche ) ) {
			return;
		}
		$menus = $this->selected_niche['sample_menus'];
		foreach ( $menus as $menu ) {
			$menu_exists = wp_get_nav_menu_object( $menu['name'] );
			if ( $menu_exists ) {
				wp_delete_nav_menu( $menu_exists );
			}
		}

	}

	public function reset_data() {
		$this->reset_editor_settings();
		$this->reset_wp_templates();
	}

}
