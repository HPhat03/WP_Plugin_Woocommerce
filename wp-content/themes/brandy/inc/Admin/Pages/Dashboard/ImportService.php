<?php

namespace Brandy\Admin\Pages\Dashboard;

use Brandy\Traits\SingletonTrait;
use SimpleXMLElement;

class ImportService {
	use SingletonTrait;

	public static function read_posts_from_csv( $file ) {

		if ( ! file_exists( $file ) ) {
			return array();
		}

		$extension = pathinfo( $file, PATHINFO_EXTENSION );

		if ( 'json' === $extension ) {
			return self::read_posts_from_json( $file );
		}

		if ( 'xml' !== $extension ) {
			return array();
		}

		$result = array();

		$xml = simplexml_load_file( $file );

		if ( false == $xml ) {
			return array();
		}

		if ( empty( $xml->row ) ) {
			return array();
		}

		foreach ( $xml->row as $row ) {
			$row_data = self::read_xml_row( $row );
			if ( empty( $row_data ) ) {
				continue;
			}
			$result[] = $row_data;
		}

		return $result;
	}

	public static function read_posts_from_json( $file ) {
		$content = file_get_contents( $file );
		$data    = json_decode( $content, true );
		$result  = array();
		foreach ( $data as $row_data ) {

			$result[] = self::read_json_row( (object) $row_data );
		}
		return $result;
	}

	public static function read_products_from_csv( $file ) {
		$result = array();
		try {

			if ( file_exists( $file ) && class_exists( '\Automattic\WooCommerce\Admin\API\OnboardingTasks' ) ) {
				$result = \Automattic\WooCommerce\Admin\API\OnboardingTasks::import_sample_products_from_csv( $file );
			}
		} catch ( \Error $error ) {
			$result = array();
		}
		return $result;
	}

	public static function read_widgets_from_csv( $file ) {

		if ( ! file_exists( $file ) ) {
			return array();
		}

		$extension = pathinfo( $file, PATHINFO_EXTENSION );

		if ( 'xml' !== $extension && 'json' !== $extension ) {
			return array();
		}

		$result = array();

		if ( 'json' === $extension ) {
			$content = file_get_contents( $file );
			$data    = (array) json_decode( $content );
		} else {
			$xml = simplexml_load_file( $file );

			if ( false == $xml ) {
				return array();
			}

			$data = json_decode( wp_json_encode( $xml ), true );
		}

		if ( empty( $data['row'] ) ) {
			return array();
		}

		foreach ( $data['row'] as $row_data ) {
			$row_data = (array) $row_data;
			if ( empty( $row_data['ID'] ) ) {
				continue;
			}
			$result[] = array(
				'id'      => $row_data['ID'],
				'title'   => $row_data['title'],
				'content' => $row_data['content'] ?? '',
			);
		}

		return $result;
	}

	public static function add_featured_image( $post_id, $featured_image, $description ) {

		if ( empty( $featured_image ) ) {
			return;
		}

		if ( ! function_exists( 'media_sideload_image' ) ) {
			require_once ABSPATH . 'wp-admin/includes/media.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/image.php';
		}
		$image_id = \media_sideload_image( $featured_image, $post_id, $description, 'id' );

		if ( ! is_wp_error( $image_id ) ) {
			\set_post_thumbnail( $post_id, $image_id );
		}

	}

	private static function read_json_attribute( $term_type, $term_name ) {

		if ( empty( $term_type ) ) {
			$term_type = 'category';
		}

		if ( 'category' !== $term_type ) {
			return array(
				'type' => 'post_tag',
				'id'   => $term_name,
			);
		}

		$term_id = self::get_term_id( $term_name, $term_name, $term_type );
		if ( empty( $term_id ) ) {
			return null;
		}

		return array(
			'type' => $term_type,
			'id'   => $term_id,
		);
	}

	private static function read_json_row( $row ) {
		$title = strval( $row->title );
		if ( empty( $title ) ) {
			return null;
		}

		$name = strval( $row->name );
		if ( empty( $name ) ) {
			return null;
		}

		$categories = array();
		if ( ! empty( $row->category ) ) {
			foreach ( $row->category as $xml_category_row ) {
				$category_row_data = self::read_json_attribute( 'category', $xml_category_row );
				if ( empty( $category_row_data ) ) {
					continue;
				}
				$categories[] = $category_row_data;
			}
		}

		if ( ! empty( $row->tags ) ) {
			foreach ( $row->tags as $xml_tag_row ) {
				$tag_row_data = self::read_json_attribute( 'post_tag', $xml_tag_row );
				if ( empty( $tag_row_data ) ) {
					continue;
				}
				$categories[] = $tag_row_data;
			}
		}

		$comments = array();
		if ( ! empty( $row->comment ) ) {
			foreach ( (array) $row->comment as $xml_comment_row ) {
				if ( empty( $xml_comment_row ) ) {
					continue;
				}
				$comments[] = strval( $xml_comment_row );
			}
		}

		$post_category = array();
		$tags_input    = array();
		foreach ( $categories as $data ) {
			if ( 'category' === $data['type'] ) {
				$post_category[] = $data['id'];
			}
			if ( 'post_tag' === $data['type'] ) {
				$tags_input[] = $data['id'];
			}
		}

		$xml_comment_status = strval( $row->comment_status ?? 'open' );
		$comment_status     = 'open';
		if ( in_array( $xml_comment_status, array( 'open', 'closed' ), true ) ) {
			$comment_status = $xml_comment_status;
		}

		return array(
			'name'           => $name,
			'title'          => $title,
			'content'        => strval( $row->content ?? '' ),
			'featured_image' => strval( $row->featured_image ?? '' ),
			'post_category'  => $post_category,
			'tags_input'     => $tags_input,
			'comment_status' => $comment_status,
			'comments'       => $comments,
			'page_template'  => strval( $row->page_template ?? '' ),
			'post_meta'      => unserialize( $row->post_meta ?? '' ),
			'dependency'   	 => strval( $row->dependency ?? '' ),
		);
	}

	private static function read_xml_row( $xml ) {
		$title = strval( $xml->title );
		if ( empty( $title ) ) {
			return null;
		}

		$name = strval( $xml->name );
		if ( empty( $name ) ) {
			return null;
		}

		$categories = array();
		foreach ( $xml->category as $xml_category_row ) {
			$category_row_data = self::read_xml_category( $xml_category_row );
			if ( empty( $category_row_data ) ) {
				continue;
			}
			$categories[] = $category_row_data;
		}

		$comments = array();
		foreach ( $xml->comment as $xml_comment_row ) {
			if ( empty( $xml_comment_row ) ) {
				continue;
			}
			$comments[] = strval( $xml_comment_row );
		}

		$post_category = array();
		$tags_input    = array();
		foreach ( $categories as $data ) {
			if ( 'category' === $data['type'] ) {
				$post_category[] = $data['id'];
			}
			if ( 'post_tag' === $data['type'] ) {
				$tags_input[] = $data['id'];
			}
		}

		$xml_comment_status = strval( $xml->comment_status );
		$comment_status     = 'open';
		if ( in_array( $xml_comment_status, array( 'open', 'closed' ), true ) ) {
			$comment_status = $xml_comment_status;
		}

		return array(
			'name'           => $name,
			'title'          => $title,
			'content'        => strval( $xml->content ),
			'featured_image' => strval( $xml->featured_image ),
			'post_category'  => $post_category,
			'tags_input'     => $tags_input,
			'comment_status' => $comment_status,
			'comments'       => $comments,
			'page_template'  => strval( $xml->page_template ),
			'post_meta'      => unserialize( $xml->post_meta ?? '' ),
		);
	}

	private static function read_xml_category( $xml ) {
		$term_name = strval( $xml );
		if ( empty( $term_name ) ) {
			return null;
		}

		$attributes = $xml->attributes();

		if ( empty( $attributes ) ) {
			return null;
		}

		$term_slug = strval( $attributes->nicename );

		if ( empty( $term_slug ) ) {
			return null;
		}

		$term_type = strval( $attributes->domain );

		if ( empty( $term_type ) ) {
			$term_type = 'category';
		}

		if ( 'category' !== $term_type ) {
			return array(
				'type' => 'post_tag',
				'id'   => $term_name,
			);
		}

		$term_id = self::get_term_id( $term_slug, $term_name, $term_type );
		if ( empty( $term_id ) ) {
			return null;
		}

		return array(
			'type' => $term_type,
			'id'   => $term_id,
		);
	}

	private static function get_term_id( $term_slug, $term_name ) {
		$slug    = 'brandy-' . $term_slug;
		$term_id = term_exists( $slug );
		if ( empty( $term_id ) ) {
			$inserted_data = wp_insert_term(
				$term_name,
				'category',
				array(
					'slug' => $slug,
				)
			);
			if ( is_wp_error( $inserted_data ) ) {
				return null;
			}
			$term_id = $inserted_data['term_id'];
		}
		return $term_id;
	}

	public static function count_posts_from_csv( $file ) {

		if ( ! file_exists( $file ) ) {
			return 0;
		}

		$extension = pathinfo( $file, PATHINFO_EXTENSION );

		if ( 'json' === $extension ) {
			$content = file_get_contents( $file );
			$data    = json_decode( $content );
			return count( $data );
		}

		if ( 'xml' !== $extension ) {
			return 0;
		}

		$xml = simplexml_load_file( $file );

		if ( false == $xml ) {
			return 0;
		}

		if ( empty( $xml->row ) ) {
			return 0;
		}

		return count( $xml->row );
	}

	public static function count_widgets_from_csv( $file ) {
		$data = self::read_widgets_from_csv( $file );
		return count( $data );
	}

	public static function count_products_from_csv( $file ) {
		try {
			if ( ! file_exists( $file ) ) {
				return 0;
			}

			if ( defined( 'WC_ABSPATH' ) && file_exists( WC_ABSPATH . 'includes/import/class-wc-product-csv-importer.php' ) ) {
				include_once WC_ABSPATH . 'includes/import/class-wc-product-csv-importer.php';

				if ( class_exists( 'WC_Product_CSV_Importer' ) ) {
					add_filter( 'locale', '__return_false', 9999 );
					$importer_class = apply_filters( 'woocommerce_product_csv_importer_class', 'WC_Product_CSV_Importer' );
					$args           = array(
						'parse'   => true,
						'mapping' => array(),
					);
					$args           = apply_filters( 'woocommerce_product_csv_importer_args', $args, $importer_class );

					$importer = new $importer_class( $file, $args );

					$raw_data = $importer->get_raw_data();

					return count( $raw_data );
				}
			} else {
				$rows = file( $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

				return count( $rows ) - 1;
			}
		} catch ( \Error $error ) {
			return 0;
		}

		return 0;
	}

	public static function data_with_counting( $data ) {

		$result = array();

		$builders = ! empty( $data['supports'] ) ? $data['supports'] : array( 'gutenber' );

		$count_products = self::count_products_from_csv( $data['sample_products'] ?? '' );
		$count_menus    = count( $data['sample_menus'] ?? array() );
		$fallback_count_pages = self::count_posts_from_csv( BRANDY_TEMPLATE_DIR . '/assets/sample-data/sample-pages.json' );

		foreach ( $builders as $builder ) {
			$posts_file         = isset( $data['sample_posts'][ $builder ] ) ? $data['sample_posts'][ $builder ] : '';
			$pages_file         = isset( $data['sample_pages'][ $builder ] ) ? $data['sample_pages'][ $builder ] : '';
			$result[ $builder ] = array(
				'posts'    => self::count_posts_from_csv( $posts_file ),
				'pages'    => self::count_posts_from_csv( $pages_file ) + $fallback_count_pages,
				'products' => $count_products,
				'widgets'  => 0,
				'menus'    => $count_menus,
			);
		}

		$data['counting'] = $result;

		return $data;
	}

}
