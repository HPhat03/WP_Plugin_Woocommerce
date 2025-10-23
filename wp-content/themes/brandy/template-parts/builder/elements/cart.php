<?php
/**
 * Template for cart section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Customizer\Elements\Cart;
use Brandy\Utils\Helpers;

	$element    = $args['element'];
	$section_id = $element['id'];
	$settings   = $element['settings'];
	$attributes = array(
		'data-builder'    => $args['builder'],
		'data-section-id' => $section_id,
	);

	if ( isset( $settings['auto_open_mini_cart'] ) ) {
		$attributes['data-auto-open-mini-cart'] = $settings['auto_open_mini_cart'] ? 'true' : 'false';
	}
	global $brandy_cart_settings;
	$brandy_cart_settings = $settings;
	?>
<div class="brandy-cart-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper">
		<?php
		$href = '#';
		if ( 'cart_page' == $settings['click_effect'] ) {
			$href = '/cart';
		}
		$items_count = 14;
		if ( \is_wc_installed() ) {
			$items_count = \WC()->cart->get_cart_contents_count();
		}
		?>
		<div class="brandy-cart-wrapper">
			<a href="<?php echo esc_url( $href ); ?>" data-click_effect="<?php echo esc_attr( $settings['click_effect'] ); ?>" class="brandy-cart-a trigger-tooltip trigger-icon" aria-label="View cart">
				<span class="brandy-cart-icon-wrap">
					<?php
						$icon = Cart::get_icon( $settings['icon'], $settings['icon_style'] );
						brandy_render_icon( $icon );
					?>
					<?php
						brandy_render_badge( $items_count, '', 'brandy-cart-qtybadge' );
					?>
					
				</span>
				<?php
				$cart_label_attributes = array(
					'class' => 'brandy-cart-label',
				);
				$display               = $settings['label']['display'] ?? array(
					'desktop' => false,
					'tablet'  => true,
					'mobile'  => null,
				);
				if ( ! Helpers::get_device_value( $display, 'desktop' ) ) {
					$cart_label_attributes['class'] .= ' is-tooltip';
				}
				if ( ! Helpers::get_device_value( $display, 'tablet' ) ) {
					$cart_label_attributes['class'] .= ' hidden-md';
				}
				if ( ! Helpers::get_device_value( $display, 'mobile' ) ) {
					$cart_label_attributes['class'] .= ' hidden-sm';
				}
				?>
				<span <?php brandy_print_dom_attributes( $cart_label_attributes ); ?>><?php echo esc_html( $settings['cart_label'] ?? 'Cart' ); ?></span>
			</a>
			<?php if ( 'dropdown' == $settings['click_effect'] ) : ?>
				<div class="brandy-cart-dropdown brandy-mini-cart" type=<?php echo esc_attr( $settings['click_effect'] ); ?>>
					<?php
					if ( ! \is_wc_installed() ) {
						?>
						<div style="padding: 20px"><?php esc_html_e( 'Please install WooCommerce', 'brandy' ); ?></div>
						<?php
					}
					if ( function_exists( 'woocommerce_mini_cart' ) ) {
						\woocommerce_mini_cart();
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
	if ( is_customize_preview() ) {
		get_template_part(
			'template-parts/common/edit-section-button',
			'',
			array(
				'part_id' => $section_id,
			)
		);
	}
	?>
	
	<?php
	if ( 'slide_in' == $settings['click_effect'] ) {
		?>
		<div class="brandy-drawer brandy-cart-drawer brandy-mini-cart" data-open-direction="<?php echo esc_attr( $settings['open_direction'] ?? 'right' ); ?>">
			<div class="widget_shopping_cart_content">
			<?php
			if ( ! \is_wc_installed() ) {
				?>
				<div class="brandy-mini-cart-wrapper">
					<div class="brandy-mini-cart-top">
						<div class="brandy-mini-cart__title">
							<h2 class="brandy-mini-cart__title__text"><?php echo wp_kses_post( sprintf( __( 'Your cart (%s)', 'brandy' ), 14 ) ); ?></h2>
							<button class="brandy-mini-cart__close" type="button" tabindex="0" title="Close mini cart"><span class="sr-only">Close panel</span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg></button>
						</div>
						<div>
							<?php esc_html_e( 'Please install WooCommerce', 'brandy' ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			if ( function_exists( 'woocommerce_mini_cart' ) ) {
				?>
					<?php \woocommerce_mini_cart(); ?>
					<?php
			}
			?>
			</div>
		</div>
		<div class="brandy-cart-overlay"></div>
		<?php
	}
	?>
</div>
