<?php
/**
 * Register theme global functions
 *
 * @package Brandy\Functions
 */

use Brandy\Core\ThemeSetup;
use Brandy\Core\Services\ProductCatalogService;
use Brandy\Core\Services\LayoutService;
use Brandy\Utils\MenuHelper;

if ( ! function_exists( 'brandy_register_configuration' ) ) {
	/**
	 * Register module for customizer
	 *
	 * @param \WP_Customize_Manager $manager Customize Manager.
	 * @param array                 $configuration {
	 * Module configuration.
	 * @type string     configuration_type  Config type.
	 * @type string     id                  Config id.
	 * @type string     label               Config label.
	 * @type string     type                Define class when panel/section is registered.
	 * @type any        default
	 * @type any        partial
	 * }
	 */
	function brandy_register_configuration( \WP_Customize_Manager $manager, $configuration ) {
		switch ( $configuration['configuration_type'] ) {
			case 'section':
				$method = 'add_section';
				break;
			case 'control':
				$method = 'add_control';
				break;
			default:
				$method = 'add_panel';
				break;
		}
		if ( 'control' === $configuration['configuration_type'] ) {
			$manager->add_setting(
				$configuration['id'],
				array(
					'default'   => $configuration['default'],
					'transport' => $configuration['transport'],
				)
			);
		}
		call_user_func( array( $manager, $method ), $configuration['id'], $configuration );
	}
}

if ( ! function_exists( 'is_block_editor_screen' ) ) {

	/**
	 * Check is block editor screen
	 *
	 * @return boolean
	 *
	 * @since 1.0
	 */
	function is_block_editor_screen() {
		if ( ! is_admin() ) {
			return false;
		}
		$screen = get_current_screen();
		if ( ! $screen->is_block_editor ) {
			return false;
		}
		return true;
	}
}

if ( ! function_exists( 'is_wc_installed' ) ) {

	/**
	 * Check whether WC is installed
	 *
	 * @return boolean
	 *
	 * @since 1.0
	 */
	function is_wc_installed() {
		return function_exists( 'WC' );
	}
}

if ( ! function_exists( 'is_elementor_installed' ) ) {

	/**
	 * Check whether Elementor is installed
	 *
	 * @return boolean
	 *
	 * @since 1.0
	 */
	function is_elementor_installed() {
		return class_exists( 'Elementor\Plugin' );
	}
}

if ( ! function_exists( 'brandy_is_starter_sites_installed' ) ) {

	/**
	 * Check whether Brandy Starter Sites is installed
	 *
	 * @return boolean
	 *
	 * @since 1.0
	 */
	function brandy_is_starter_sites_installed() {
		return defined( 'BRANDYSITES_VERSION' );
	}
}

if ( ! function_exists( 'is_brandy_blocks_installed' ) ) {

	/**
	 * Check whether Brandy Blocks plugin is installed
	 *
	 * @return boolean
	 *
	 * @since 1.0
	 */
	function is_brandy_blocks_installed() {
		return defined( 'BRANDY_BLOCKS_VERSION' );
	}
}

if ( ! function_exists( 'brandy_get_reading_time' ) ) {

	/**
	 * Get reading time for given content.
	 * Calculate by minutes.
	 *
	 * @return string.
	 *
	 * @since 1.0
	 */
	function brandy_get_reading_time( $content = '' ) {

		$WORDS_PER_MINUTE = 250;

		$wordcount = str_word_count( wp_strip_all_tags( $content ) );

		$reading_time = ceil( $wordcount / $WORDS_PER_MINUTE );

		return sprintf( '%1$s %2$s', _n( 'minute', 'minutes', $reading_time, 'brandy' ), $reading_time );

	}
}

if ( ! function_exists( 'brandy_current_niche' ) ) {

	/**
	 * Get current site niche.
	 *
	 * @return string|boolean Current niche.
	 *
	 * @since 1.0
	 */
	function brandy_current_niche() {
		return get_option( 'brandy_current_niche', 'default' );
	}
}

if ( ! function_exists( 'brandy_is_current_niche' ) ) {

	/**
	 * Check given niche is current site niche.
	 *
	 * @param string $niche Niche ID.
	 *
	 * @return string|boolean Result.
	 *
	 * @since 1.0
	 */
	function brandy_is_current_niche( $niche ) {
		return brandy_current_niche() == $niche;
	}
}

if ( ! function_exists( 'brandy_get_template_part' ) ) {

	/**
	 * Get template part by niche.
	 * Allow developer to alter theme template part.
	 * Developer can alter part by function brandy_register_template_part.
	 *
	 * @param   string          $slug   Part slug.
	 * @param   string|null     $name   Template name.
	 * @param   array           $args   Same as get_template_part args
	 *
	 * @since 1.0
	 */
	function brandy_get_template_part( $slug, $name = \null, $args = array() ) {

		$template = $slug . ( ! empty( $name ) ? "-$name" : '' );

		$template_file = apply_filters( "brandy/$template", '' );

		if ( empty( $template_file ) || ! file_exists( $template_file ) ) {
			return get_template_part( $slug, $name, $args );
		}

		require $template_file;
	}
}

if ( ! function_exists( 'brandy_get_nav_menu_name' ) ) {
	/**
	 * Returns menu name.
	 * If menu doesn't exist, find menu name based on where the menu is placing (Header/Footer).
	 *
	 * @param string $menu_name Menu name to check exists
	 * @param string $builder Header or Footer builder
	 * @return string Menu name
	 *
	 * @since 1.0
	 */
	function brandy_get_nav_menu_name( $menu_name, $builder = 'header' ) {
		if ( wp_get_nav_menu_object( $menu_name ) ) {
			return $menu_name;
		}
		$builder_locations = array();
		if ( 'header' === $builder ) {
			$builder_locations = MenuHelper::get_header_locations();
		}
		if ( 'footer' === $builder ) {
			$builder_locations = MenuHelper::get_footer_locations();
		}
		$all_locations = array_merge(
			array_keys( $builder_locations ),
			array_keys( MenuHelper::get_main_locations() )
		);
		while ( ! empty( $all_locations ) ) {
			$location              = array_shift( $all_locations );
			$menu_name_by_location = wp_get_nav_menu_name( $location );
			if ( ! empty( $menu_name_by_location ) ) {
				return $menu_name_by_location;
			}
		}

		return $menu_name;
	}
}

if ( ! function_exists( 'brandy_the_post_thumbnail' ) ) {
	/**
	 * Print current post thumbnail.
	 * Show default thumbnail when post doesn't have featured image.
	 *
	 * @param int|WP_Post
	 *
	 * @since 1.0
	 */
	function brandy_the_post_thumbnail( $post = null ) {
		$thumbnail = get_the_post_thumbnail( $post );
		if ( empty( $thumbnail ) ) {
			echo wp_kses_post( brandy_get_post_placeholder_thumbnail() );
		} else {
			echo wp_kses_post( $thumbnail );
		}
	}
}

if ( ! function_exists( 'brandy_get_post_placeholder_thumbnail' ) ) {
	/**
	 * Returns placeholder feature image for post
	 * which doesn't have thumnbnail
	 *
	 * @return string Image tag
	 * @since 1.0
	 */
	function brandy_get_post_placeholder_thumbnail( $attr = array() ) {
		$src          = brandy_get_post_placeholder_thumbnail_url();
		$default_attr = array(
			'src' => esc_url( $src ),
			'alt' => 'Thumbnail placeholder',
		);
		$attr         = wp_parse_args( $default_attr, $attr );
		$attr_string  = '';

		ob_start();
		brandy_print_dom_attributes( $attr );
		$attr_string = ob_get_contents();
		ob_end_clean();

		return sprintf( '<img %s/>', $attr_string );
	}
}

if ( ! function_exists( 'brandy_get_post_placeholder_thumbnail_url' ) ) {
	/**
	 * Returns placeholder feature image for post
	 * which doesn't have thumnbnail
	 *
	 * @return string Image tag
	 * @since 1.0
	 */
	function brandy_get_post_placeholder_thumbnail_url() {
		return BRANDY_TEMPLATE_URL . '/assets/images/woocommerce-placeholder-gray.webp';
	}
}

if ( ! function_exists( 'brandy_get_user_device' ) ) {

	/**
	 * Get user device.
	 *
	 * @return string User device.
	 */
	function brandy_get_user_device() {
		$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
		if ( empty( $user_agent ) ) {
			return null;
		}
		$mobile_devices = array( 'mobile', 'android', 'iphone', 'ipod', 'blackberry', 'opera mini', 'iemobile' );
		$tablet_devices = array( 'tablet', 'ipad', 'playbook', 'kindle', 'nexus 7', 'nexus 10' );

		$posible_mobile_devices = array_merge( $mobile_devices, $tablet_devices );

		foreach ( $posible_mobile_devices as $device ) {
			if ( strpos( $user_agent, $device ) !== false ) {
				return 'mobile';
			}
		}

		return 'desktop';
	}
}


if ( ! function_exists( 'brandy_get_body_attributes' ) ) {
	function brandy_get_body_attributes() {
		global $post;
		$current_niche = brandy_current_niche();
		return apply_filters(
			'brandy_body_attributes',
			array_merge(
				empty( $current_niche ) ? array() : array(
					'data-current-niche' => $current_niche,
				),
				array(
					'data-loop-product-layout'     => ProductCatalogService::get_product_layout(),
					'data-brandy-blocks-installed' => is_brandy_blocks_installed() ? 'true' : 'false',
				)
			)
		);
	}
}

if ( ! function_exists( 'brandy_get_editable_class' ) ) {
	/**
	 * Returns class for wrapper when in customize mode
	 */
	function brandy_get_editable_class( $edit_type = 'section' ) {
		if ( is_customize_preview() ) {
			return 'row' === $edit_type ? 'editable-part editable-row-part' : 'editable-part editable-element-part';
		}
		return '';
	}
}

if ( ! function_exists( 'brandy_get_editable_attributes' ) ) {
	/**
	 * Returns attrubutes for wrapper when in customize mode
	 *
	 * @param string $section_id Section id.
	 */
	function brandy_get_editable_attributes( string $section_id ) {
		return true ? "data-section-id=$section_id" : '';
	}
}

if ( ! function_exists( 'brandy_print_dom_attributes' ) ) {
	/**
	 * Print DOM element attributes from given array
	 *
	 * @param array $attributes
	 *
	 * @return void
	 */
	function brandy_print_dom_attributes( $attributes ) {
		foreach ( $attributes as $attr_name => $attr_value ) {
			echo esc_attr( $attr_name );
			if ( ! empty( $attr_value ) ) {
				echo '="' . esc_attr( $attr_value ) . '"';
			}
		}
	}
}

if ( ! function_exists( 'brandy_get_devices' ) ) {
	/**
	 * Returns all device of theme
	 *
	 * @return array
	 */
	function brandy_get_devices() {
		return array( 'desktop', 'tablet', 'mobile' );
	}
}

if ( ! function_exists( 'brandy_get_enabled_device_classes' ) ) {

	/**
	 * Return classes which indicate which device is hidden
	 *
	 * @param array $enabled_devices List enabled devices.
	 *
	 * @return string
	 */
	function brandy_get_enabled_device_classes( $enabled_devices ) {
		if ( ! is_array( $enabled_devices ) ) {
			return '';
		}
		$hidden_devices = array_diff( array( 'desktop', 'mobile' ), $enabled_devices );
		$classes        = implode(
			' ',
			array_map(
				function( $device ) {
					if ( 'mobile' === $device ) {
						return 'hidden-md hidden-sm';
					}
					return 'hidden-lg';
				},
				$hidden_devices
			)
		);
		return $classes;
	}
}

if ( ! function_exists( 'brandy_render_badge' ) ) {
	/**
	 * Render Brandy badge
	 *
	 * @param string $number
	 * @param string $attrs
	 * @param string $class
	 *
	 * @return void
	 */
	function brandy_render_badge( $number, $attrs = '', $class = '' ) {
		get_template_part(
			'template-parts/common/badge',
			'',
			array(
				'number' => $number,
				'attrs'  => $attrs,
				'class'  => $class,
			)
		);
	}
}

if ( ! function_exists( 'brandy_render_icon' ) ) {
	/**
	 * Render Brandy icon
	 *
	 * @param string $icon Icon source
	 * @param string $class
	 * @param string $attrs
	 *
	 * @return void
	 */
	function brandy_render_icon( $icon, $attrs = array() ) {
		get_template_part(
			'template-parts/common/icon',
			'',
			array(
				'icon'  => $icon,
				'attrs' => $attrs,
			)
		);
	}
}

if ( ! function_exists( 'brandy_render_wishlist' ) ) {

	/**
	 * Render wishlist content template
	 */
	function brandy_render_wishlist( $settings ) {
		get_template_part(
			'template-parts/wishlist/wishlist-drawer',
			'',
			array(
				'settings' => $settings,
			)
		);
	}
}

if ( ! function_exists( 'brandy_get_rating_html' ) ) {
	/**
	 * Display product ratings
	 *
	 * @param int $rating               Rating for this product (overall or single)
	 * @param int $count                Total reviews for this product
	 * @param boolean $only_stars       Show only stars or not
	 * @param boolean $total_reviews    .
	 */
	function brandy_get_rating_html( $product, $rating, $rating_count = 0, $show_only_stars = false, $show_overall = false, $review_count = 0 ) {

		// if ( empty( $product ) ) {
		// 	return;
		// }

		brandy_get_template_part(
			'template-parts/rating',
			null,
			array(
				// 'product'         => $product,
				'rating'          => $rating,
				'rating_count'    => $rating_count,
				'show_only_stars' => $show_only_stars,
				'review_count'    => $review_count,
				'show_overall'    => $show_overall,
			)
		);
	}
}

if ( ! function_exists( 'brandy_get_current_page_id' ) ) {
	/**
	 * Get current page ID
	 */
	function brandy_get_current_page_id() {
		if ( is_front_page() ) {
			return get_option( 'page_on_front' );
		} elseif ( is_home() ) {
			return get_option( 'page_for_posts' );
		} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			return wc_get_page_id( 'shop' );
		} else {
			return get_the_ID();
		}
	}
}

if ( ! function_exists( 'brandy_render_link_button' ) ) {
	function brandy_render_link_button( $args ) {
		$default_args = array(
			'text'  => __( 'Button', 'brandy' ),
			'href'  => '#',
			'class' => '',
		);
		$args         = wp_parse_args( $args, $default_args );
		?>
			<a class="wp-block-button__link wp-element-button <?php echo esc_attr( $args['class'] ); ?>" href="<?php echo esc_url( $args['href'] ); ?>"><?php echo esc_html( $args['text'] ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'brandy_get_products_collection_demo_tax_queries' ) ) {
	function brandy_get_products_collection_demo_tax_queries() {
		$queries        = array();
		$list_demo_cats = brandy_get_demo_cats();
		if ( ! empty( $list_demo_cats ) ) {
			$queries['product_cat'] = $list_demo_cats;
		}
		return $queries;
	}
}

if ( ! function_exists( 'brandy_get_demo_cats' ) ) {
	function brandy_get_demo_cats() {
		return apply_filters( 'brandy_product_demo_cats', array() );
	}
}

if ( ! function_exists( 'brandy_get_builder_template' ) ) {

	/**
	 * Returns template data for specific builder
	 *
	 * @param string $builder Given builder.
	 *
	 * @return array|null Builder template data.
	 */
	function brandy_get_builder_template( $builder ) {

		$fn = 'brandy_get_' . $builder . '_template';

		if ( ! is_callable( $fn ) ) {
			return null;
		}
		return call_user_func( $fn );
	}
}

if ( ! function_exists( 'brandy_get_current_page_id' ) ) {

	/**
	 * Get current page ID.
	 *
	 * @return int Current page ID.
	 */
	function brandy_get_current_page_id() {
		if ( function_exists( 'is_shop' ) && \is_shop() ) {
			return \wc_get_page_id( 'shop' );
		}
		if ( function_exists( 'is_cart' ) && \is_cart() ) {
			return wc_get_page_id( 'cart' );
		}
		if ( function_exists( 'is_checkout' ) && \is_checkout() ) {
			return wc_get_page_id( 'checkout' );
		}

		if ( is_block_editor_screen() ) {
			return get_the_ID();
		}

		global $wp_query;

		if ( empty( $wp_query ) ) {
			return get_the_ID();
		}

		$page_id = $wp_query->get_queried_object_id();

		return $page_id;
	}
}

if ( ! function_exists( 'brandy_get_home_page_id' ) ) {
	/**
	 * Get home page id.
	 * Returns null home page isn't assigned.
	 *
	 * @return int|null Id for home page
	 *
	 * @since 1.0
	 */
	function brandy_get_home_page_id() {
		$show_on_front = get_option( 'show_on_front' );

		if ( 'page' !== $show_on_front ) {
			return null;
		}

		$home_page_id = get_option( 'page_on_front', null );

		return $home_page_id;

	}
}

if ( ! function_exists( 'brandy_is_home' ) ) {
	/**
	 * Check is homepage
	 *
	 * @return bool
	 *
	 * @since 1.0
	 */
	function brandy_is_home() {

		$home_page_id = brandy_get_home_page_id();

		return is_home() || ( brandy_get_current_page_id() == $home_page_id );

	}
}

if ( ! function_exists( 'brandy_is_thankyou_page' ) ) {

	/**
	 * Check if current page is thank you page.
	 *
	 * @return boolean
	 */
	function brandy_is_thankyou_page() {
		return \is_wc_installed() && function_exists( 'is_wc_endpoint_url' ) && \is_wc_endpoint_url( 'order-received' );
	}
}

if ( ! function_exists( 'brandy_get_blog_page_id' ) ) {
	/**
	 * Get blog page id.
	 * Returns null blog page isn't assigned.
	 *
	 * @return int|null Id for blog page
	 *
	 * @since 1.0
	 */
	function brandy_get_blog_page_id() {
		$show_on_front = get_option( 'show_on_front' );

		if ( 'page' !== $show_on_front ) {
			return null;
		}

		$blog_page_id = get_option( 'page_for_posts', null );

		return $blog_page_id;

	}
}

if ( ! function_exists( 'brandy_get_blog_page_url' ) ) {
	/**
	 * Get blog page url.
	 * Returns # blog page isn't assigned.
	 *
	 * @return string Url for blog page
	 *
	 * @since 1.0
	 */
	function brandy_get_blog_page_url() {

		$blog_page_id = brandy_get_blog_page_id();

		if ( empty( $blog_page_id ) ) {
			return '#';
		}

		$url = add_query_arg( array( 'page_id' => $blog_page_id ), home_url() );

		return $url;
	}
}

if ( ! function_exists( 'brandy_get_shop_page_id' ) ) {

	/**
	 * Get shop page ID.
	 *
	 * @return int|null Shop page ID.
	 */
	function brandy_get_shop_page_id() {
		return function_exists( 'wc_get_page_id' ) ? \wc_get_page_id( 'shop' ) : null;
	}
}

if ( ! function_exists( 'brandy_get_shop_page_url' ) ) {
	/**
	 * Get shop page url.
	 * Returns # when WooCommerce is not installed.
	 *
	 * @return string Url for shop page
	 *
	 * @since 1.0
	 */
	function brandy_get_shop_page_url() {
		return function_exists( 'wc_get_page_permalink' ) ? \wc_get_page_permalink( 'shop' ) : '#';
	}
}

if ( ! function_exists( 'brandy_get_cart_page_id' ) ) {

	/**
	 * Get cart page ID.
	 *
	 * @return int|null Cart page ID.
	 */
	function brandy_get_cart_page_id() {
		return function_exists( 'wc_get_page_id' ) ? \wc_get_page_id( 'cart' ) : null;
	}
}

if ( ! function_exists( 'brandy_get_cart_page_url' ) ) {
	/**
	 * Get cart page url.
	 * Returns # when WooCommerce is not installed.
	 *
	 * @return string Url for cart page
	 *
	 * @since 1.0
	 */
	function brandy_get_cart_page_url() {
		return function_exists( 'wc_get_cart_url' ) ? \wc_get_cart_url() : '#';
	}
}

if ( ! function_exists( 'brandy_get_checkout_page_id' ) ) {

	/**
	 * Get checkout page ID.
	 *
	 * @return int|null Checkout page ID.
	 */
	function brandy_get_checkout_page_id() {
		return function_exists( 'wc_get_page_id' ) ? \wc_get_page_id( 'checkout' ) : null;
	}
}

if ( ! function_exists( 'brandy_get_checkout_page_url' ) ) {
	/**
	 * Get checkout page url.
	 * Returns # when WooCommerce is not installed.
	 *
	 * @return string Url for checkout page
	 *
	 * @since 1.0
	 */
	function brandy_get_checkout_page_url() {
		return function_exists( 'wc_get_checkout_url' ) ? \wc_get_checkout_url() : '#';
	}
}

if ( ! function_exists( 'brandy_get_contact_us_page_id' ) ) {
	/**
	 * Get contact us page id.
	 * Returns null contact us page isn't assigned.
	 *
	 * @return int|null Id for contact us page
	 *
	 * @since 1.1.7
	 */
	function brandy_get_contact_us_page_id() {
		$pages = get_posts(
			array(
				'post_type'      => 'page',
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'contact-us',
				'posts_per_page' => 1,
			)
		);

		if ( ! empty( $pages ) ) {
			return $pages[0]->ID;
		}
		return null;
	}
}

if ( ! function_exists( 'brandy_get_contact_us_page_url' ) ) {
	/**
	 * Get contact us page url.
	 * Returns null contact us page isn't assigned.
	 *
	 * @return string|null Url for contact us page
	 *
	 * @since 1.1.7
	 */
	function brandy_get_contact_us_page_url() {
		$blog_page_id = brandy_get_contact_us_page_id();

		if ( empty( $blog_page_id ) ) {
			return '#';
		}

		$url = add_query_arg( array( 'page_id' => $blog_page_id ), home_url() );

		return $url;

	}
}

if ( ! function_exists( 'brandy_get_about_us_page_id' ) ) {
	/**
	 * Get about us page id.
	 * Returns null about us page isn't assigned.
	 *
	 * @return int|null Id for about us page
	 *
	 * @since 1.1.7
	 */
	function brandy_get_about_us_page_id() {
		$pages = get_posts(
			array(
				'post_type'      => 'page',
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'about-us',
				'posts_per_page' => 1,
			)
		);

		if ( ! empty( $pages ) ) {
			return $pages[0]->ID;
		}
		return null;
	}
}

if ( ! function_exists( 'brandy_get_about_us_page_url' ) ) {
	/**
	 * Get about us page url.
	 * Returns null about us page isn't assigned.
	 *
	 * @return string|null Url for about us page
	 *
	 * @since 1.1.7
	 */
	function brandy_get_about_us_page_url() {
		$blog_page_id = brandy_get_about_us_page_id();

		if ( empty( $blog_page_id ) ) {
			return '#';
		}

		$url = add_query_arg( array( 'page_id' => $blog_page_id ), home_url() );

		return $url;

	}
}

if ( ! function_exists( 'brandy_get_login_url' ) ) {
	/**
	 * Get login page url.
	 * Returns wp login page when WooCommerce is not installed.
	 *
	 * @return string Url for login page
	 * 
	 * @deprecated 1.4
	 *
	 * @since 1.0
	 */
	function brandy_get_login_url() {
		return function_exists( 'wc_get_account_endpoint_url' ) ? \wc_get_account_endpoint_url( 'dashboard' ) : wp_login_url();
	}
}

if ( ! function_exists( 'brandy_get_my_account_page_url' ) ) {
	/**
	 * Get my account page url.
	 * Returns wp account page when WooCommerce is not installed.
	 *
	 * @return string Url for account page
	 * 
	 * @since 1.4
	 */
	function brandy_get_my_account_page_url( $section = 'dashboard' ) {
		return function_exists( 'wc_get_account_endpoint_url' ) ? \wc_get_account_endpoint_url( $section ) : wp_login_url();
	}
}

if ( ! function_exists( 'brandy_get_logout_url' ) ) {
	/**
	 * Get logout page url.
	 * Returns wp logout page when WooCommerce is not installed.
	 *
	 * @return string Url for logout page
	 *
	 * @since 1.0
	 */
	function brandy_get_logout_url() {
		return function_exists( 'wc_get_account_endpoint_url' ) ? \wc_get_account_endpoint_url( 'customer-logout' ) : wp_logout_url();
	}
}

if ( ! function_exists( 'brandy_get_terms_and_conditions_page_id' ) ) {
	/**
	 * Get terms and conditions page id.
	 * Returns null terms and conditions page isn't assigned.
	 *
	 * @return int|null Id for terms and conditions page
	 *
	 * @since 1.4
	 */
	function brandy_get_terms_and_conditions_page_id() {
		return get_option( 'woocommerce_terms_page_id', null );
	}
}

if ( ! function_exists( 'brandy_get_terms_and_conditions_page_url' ) ) {
	/**
	 * Get logout page url.
	 * Returns wp logout page when WooCommerce is not installed.
	 *
	 * @return string Url for logout page
	 *
	 * @since 1.4
	 */
	function brandy_get_terms_and_conditions_page_url() {
		$terms_page_id = brandy_get_terms_and_conditions_page_id();

		if ( empty( $terms_page_id ) ) {
			return '#';
		}

		$url = add_query_arg( array( 'page_id' => $terms_page_id ), home_url() );

		return $url;
	}
}

if ( ! function_exists( 'brandy_get_privacy_policy_page_id' ) ) {
	/**
	 * Get privacy policy page id.
	 * Returns null privacy policy page isn't assigned.
	 *
	 * @return int|null Id for privacy policy page
	 *
	 * @since 1.4
	 */
	function brandy_get_privacy_policy_page_id() {
		return get_option( 'wp_page_for_privacy_policy', null );
	}
}

if ( ! function_exists( 'brandy_get_privacy_policy_page_url' ) ) {
	/**
	 * Get privacy policy page url.
	 * Returns null privacy policy page isn't assigned.
	 *
	 * @return string|null Url for privacy policy page
	 *
	 * @since 1.4
	 */
	function brandy_get_privacy_policy_page_url() {
		$privacy_page_id = brandy_get_privacy_policy_page_id();

		if ( empty( $privacy_page_id ) ) {
			return '#';
		}

		$url = add_query_arg( array( 'page_id' => $privacy_page_id ), home_url() );

		return $url;
	}
}

if ( ! function_exists( 'brandy_get_refund_returns_page_url' ) ) {
	/**
	 * Get refund returns page url.
	 * Returns wp refund returns page when WooCommerce is not installed.
	 *
	 * @return string Url for refund returns page
	 * 
	 * @since 1.4
	 */
	function brandy_get_refund_returns_page_url() {
		$page = get_page_by_path( 'refund-returns' );

		if ( empty( $page ) ) {
			return '#';
		}

		$url = add_query_arg( array( 'page_id' => $page->ID ), home_url() );

		return $url;
	}
}


if ( ! function_exists( 'brandy_get_wc_add_to_cart_button' ) ) {
	/**
	 * Get WC add to cart button
	 *
	 * @param \WC_Product $product Product object.
	 * @param array $args Button arguments.
	 * @return string Button HTML.
	 */
	function brandy_get_wc_add_to_cart_button( $product, $args = array() ) {

		if ( ! \is_wc_installed() ) {
			return;
		}

		if ( empty( $product ) ) {
			return;
		}

		$tag = isset( $args['tag'] ) ? $args['tag'] : 'button';

		if ( ! is_product() && in_array( $product->get_type(), array( 'variable', 'grouped' ), true ) ) {
			$tag = 'a';
		}

		$is_ajax = isset( $args['is_ajax'] ) ? $args['is_ajax'] : false;

		$default_classes = isset( $args['class'] ) ? explode( ' ', $args['class'] ) : array();

		$target_classes = array(
			esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ?? '' ),
			'add_to_cart_button',
			'product_type_' . $product->get_type(),
			$is_ajax && $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
		);

		$final_class = implode( ' ', array_unique( array_merge( $default_classes, $target_classes ) ) );

		$default_attributes = array_merge(
			array(
				'data-product_id'  => $product->get_id(),
				'data-product_sku' => $product->get_sku(),
				'aria-label'       => $product->add_to_cart_description(),
				'aria-describedby' => $product->add_to_cart_aria_describedby(),
				'rel'              => 'nofollow',
			),
			'a' === $tag ? array(
				'href' => $product->add_to_cart_url(),
			) : array(),
			( 'button' === $tag && ! $is_ajax ) ? array(
				'type' => 'submit',
			) : array()
		);

		$button_settings = array(
			'quantity'   => isset( $args['quantity'] ) ? $args['quantity'] : 1,
			'class'      => $final_class,
			'attributes' => isset( $args['attributes'] ) ? array_merge( $default_attributes, $args['attributes'] ) : $default_attributes,
		);

		return sprintf(
			'<%1$s data-quantity="%2$s" class="%3$s" %4$s>%6$s<span class="add_to_cart_button__text">%5$s</span></%1s>',
			esc_attr( $tag ),
			esc_attr( $button_settings['quantity'] ),
			esc_attr( $button_settings['class'] ),
			\wc_implode_html_attributes( $button_settings['attributes'] ),
			! empty( $args['text'] ) ? esc_html( $args['text'] ) : esc_html( $product->add_to_cart_text() ),
			isset( $args['icon'] ) ? $args['icon'] : ''
		);
	}
}

if ( ! function_exists( 'brandy_wc_loop_product_item' ) ) {

	/**
	 * Render WC loop product item
	 */
	function brandy_wc_loop_product_item() {
		$product_layout = ProductCatalogService::get_product_layout();
		$layout         = LayoutService::get_layout( 'loop-product-item' );
		if ( ! isset( $layout ) ) {
			return;
		}
		$path = $layout[ $product_layout ];
		if ( ! isset( $path ) || ! file_exists( $path ) ) {
			return;
		}

		require $path;

	}
}

if ( ! function_exists( 'brandy_loop_product_item' ) ) {

	/**
	 * Render loop product item
	 *
	 * @param \WC_Product $product Product object.
	 * @param array $display_settings Display settings.
	 * @return void
	 */
	function brandy_loop_product_item( $product, $display_settings = array() ) {
		$product_layout = ProductCatalogService::get_product_layout();
		$layout         = LayoutService::get_layout( 'block-loop-product-item' );
		if ( ! isset( $layout ) ) {
			return;
		}
		$path = $layout[ $product_layout ];
		if ( ! isset( $path ) || ! file_exists( $path ) ) {
			return;
		}

		require $path;

	}
}

if ( ! function_exists( 'brandy_wc_loop_product_item_attributes' ) ) {

	/**
	 * Render WC loop product item attributes
	 *
	 * @param \WC_Product $product Product object.
	 * @return void
	 */
	function brandy_wc_loop_product_item_attributes( $product = null ) {
		if ( ! is_wc_installed() ) {
			return;
		}
		$attributes = array(
			'class'       => implode( ' ', \wc_get_product_class( 'brandy-loop-product', $product ) ),
			'data-layout' => esc_attr( ProductCatalogService::get_product_layout() ),
		);

		brandy_print_dom_attributes( $attributes );
	}
}

if ( ! function_exists( 'brandy_get_product_collection_block_content' ) ) {
	/**
	 * Get product collection block content
	 *
	 * @param array $args Arguments.
	 * @return string Block content.
	 * @since 1.4
	 */
	function brandy_get_product_collection_block_content( $args = array() ) {
		ob_start();

		$type = $args['type'] ?? '';

		$args = apply_filters( 'brandy_products_collection_block_content_args', $args );

		$options = array(
			'perPage'             => $args['perPage'] ?? apply_filters( 'brandy_products_collection_per_page', 8 ),
			'columns'             => $args['columns'] ?? apply_filters( 'brandy_products_collection_column', 4 ),
			'taxQuery'            => $args['taxQuery'] ?? \brandy_get_products_collection_demo_tax_queries(),
			'featured'            => $args['featured'] ?? false,
			'onSale'              => $args['onSale'] ?? false,
			'includeDemoOnly'     => $args['includeDemoOnly'] ?? true,
			'pagination'          => $args['pagination'] ?? false,
			'pages'               => $args['pages'] ?? 1,
			'inheritQuery'        => $args['inheritQuery'] ?? false,
			'relatedByTags'       => $args['relatedByTags'] ?? false,
			'relatedByCategories' => $args['relatedByCategories'] ?? false,
			'heading'             => $args['heading'] ?? '',
			'templateLayout'      => $args['templateLayout'] ?? apply_filters( 'brandy_sites_query_product_layout', BRANDY_TEMPLATE_DIR . '/template-parts/query-product-layout.php' ),
		);

		$block_options = array(
			'queryId'              => 10,
			'query'                => array(
				'perPage'                       => $options['perPage'],
				'pages'                         => $options['pages'],
				'offset'                        => 0,
				'postType'                      => 'product',
				'search'                        => '',
				'order'                         => 'asc',
				'orderBy'                       => 'title',
				'exclude'                       => array(),
				'inherit'                       => $options['inheritQuery'],
				'taxQuery'                      => array(),
				'isProductCollectionBlock'      => true,
				'featured'                      => false,
				'woocommerceOnSale'             => false,
				'woocommerceStockStatus'        => array( 'instock', 'outofstock', 'onbackorder' ),
				'woocommerceAttributes'         => array(),
				'woocommerceHandPickedProducts' => array(),
			),
			'tagName'              => 'div',
			'displayLayout'        => array(
				'type'          => 'flex',
				'columns'       => $options['columns'],
				'shrinkColumns' => true,
			),
			'collection'           => 'woocommerce/product-collection/' . $type,
			'hideControls'         => array( 'inherit' ),
			'queryContextIncludes' => array( 'collection' ),
			'align'                => 'wide',
		);

		if ( ! empty( $options['relatedByTags'] ) ) {
			$block_options['query']['relatedBy']['tags'] = true;
		}
		if ( ! empty( $options['relatedByCategories'] ) ) {
			$block_options['query']['relatedBy']['categories'] = true;
		}

		if ( ! empty( $options['includeDemoOnly'] ) ) {
			$block_options['query']['taxQuery'] = $options['taxQuery'];
		}

		if ( 'new-arrivals' === $type ) {
			$block_options['query']['orderBy']   = 'date';
			$block_options['query']['order']     = 'desc';
			$block_options['query']['timeFrame'] = array(
				'operator' => 'in',
				'value'    => '-3 months',
			);
			$block_options['hideControls']       = array( 'inherit', 'order' );
		}

		if ( 'on-sale' === $type ) {
			$block_options['query']['woocommerceOnSale'] = true;
			$block_options['hideControls']               = array( 'inherit', 'on-sale' );
		}

		if ( 'featured' === $type ) {
			$block_options['query']['featured'] = true;
		}

		if ( 'top-rated' === $type ) {
			$block_options['query']['orderBy'] = 'rating';
			$block_options['query']['order']   = 'desc';
			$block_options['hideControls']     = array( 'inherit', 'order' );
		}

		if ( 'best-sellers' === $type ) {
			$block_options['query']['orderBy'] = 'popularity';
			$block_options['query']['order']   = 'desc';
			$block_options['hideControls']     = array( 'inherit', 'order' );
		}

		if ( ! empty( $args['slider'] ) ) {
			$slider_settings                 = array(
				'enabled'                   => true,
				'loop'                      => false,
				'slides'                    => array(
					'desktop' => $args['slider']['slides']['desktop'] ?? 4,
					'tablet'  => $args['slider']['slides']['tablet'] ?? 2,
					'mobile'  => $args['slider']['slides']['mobile'] ?? 2,
				),
				'gap'                       => '30px',
				'speed'                     => 1000,
				'autoplay'                  => false,
				'pauseOnHover'              => true,
				'pauseOnFocus'              => true,
				'pauseOnInteraction'        => true,
				'buttonsOffsetBasedOnImage' => $args['slider']['buttonsOffsetBasedOnImage'] ?? true,
			);
			$options['sliderSettings']       = $slider_settings;
			$block_options['sliderSettings'] = $slider_settings;
		}

		?>
		<!-- wp:woocommerce/product-collection <?php echo wp_kses_post( wp_json_encode( $block_options ) ); ?> -->
		<div class="wp-block-woocommerce-product-collection alignwide">

			<?php echo wp_kses_post( $options['heading'] ); ?>

			<!-- wp:woocommerce/product-template {"className":"brandy-site-product-template","layout":{"type":"default"}} -->
			<?php
			$query_product_layout = $options['templateLayout'];
			if ( file_exists( $query_product_layout ) ) {
				require $query_product_layout;
			}
			?>
			<!-- /wp:woocommerce/product-template -->

			<?php if ( ! empty( $options['pagination'] ) ) : ?>
				<!-- wp:group {"layout":{"type":"constrained","justifyContent":"right"}} -->
				<div class="wp-block-group">
					<!-- wp:query-pagination {"paginationArrow":"arrow","showLabel":false,"layout":{"type":"flex","justifyContent":"right"}} -->
						<!-- wp:query-pagination-previous /-->

						<!-- wp:query-pagination-numbers /-->

						<!-- wp:query-pagination-next /-->
					<!-- /wp:query-pagination -->
				</div>
				<!-- /wp:group -->
			<?php endif; ?>

			<!-- wp:woocommerce/product-collection-no-results -->
			<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","flexWrap":"wrap"}} -->
			<div class="wp-block-group"><!-- wp:paragraph {"fontSize":"medium"} -->
				<p class="has-medium-font-size"><strong><?php echo esc_html__( 'No results found', 'brandy' ); ?></strong></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>
				<?php
				printf(
					esc_html__( 'You can try %1$sclearing any filters%2$s or head to our %3$sstore\'s home%4$s', 'brandy' ),
					'<a class="wc-link-clear-any-filters" href="#">',
					'</a>',
					'<a class="wc-link-stores-home" href="' . esc_url( brandy_get_shop_page_url() ) . '">',
					'</a>'
				);
				?>
				</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- /wp:woocommerce/product-collection-no-results -->
		</div>
		<!-- /wp:woocommerce/product-collection -->
		<?php
		return ob_get_clean();
	}
}
