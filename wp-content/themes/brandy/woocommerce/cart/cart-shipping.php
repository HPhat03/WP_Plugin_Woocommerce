<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
?>

<?php if ( $available_methods ) : ?>
	<div id="shipping_method" class="woocommerce-shipping-methods">
		<?php foreach ( $available_methods as $method ) : ?>
			<div class="woocommerce-shipping-methods__item">
				<div class="woocommerce-shipping-methods__item-head">
					<label>
						<?php
						if ( 1 < count( $available_methods ) ) {
							printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping-method" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
						} else {
							printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping-method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
						}
						$method_label = $method->get_label();
						?>
						<span class="woocommerce-shipping-methods__item-label"><?php echo wp_kses_post( $method_label ); ?></span>
					</label>
				</div>
				<div class="woocommerce-shipping-methods__item-tail">
					<?php
					$has_cost  = 0 < $method->cost;
					$hide_cost = ! $has_cost && in_array( $method->get_method_id(), array( 'free_shipping', 'local_pickup' ), true );
					$cost_text = '';
					if ( $has_cost && ! $hide_cost ) {
						if ( WC()->cart->display_prices_including_tax() ) {
							$cost_text = wc_price( $method->cost + $method->get_shipping_tax() );
							if ( $method->get_shipping_tax() > 0 && ! wc_prices_include_tax() ) {
								$cost_text .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
							}
						} else {
							$cost_text = wc_price( $method->cost );
							if ( $method->get_shipping_tax() > 0 && wc_prices_include_tax() ) {
								$cost_text .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
							}
						}
					}
					?>
					<span class="woocommerce-shipping_methods__item-cost"><?php echo wp_kses_post( $cost_text ); ?></span>
					<?php do_action( 'woocommerce_after_shipping_rate', $method, $index ); ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php if ( is_cart() ) : ?>
		<p class="woocommerce-shipping-destination">
			<?php
			if ( $formatted_destination ) {
				// Translators: $s shipping destination.
				printf( esc_html__( 'Shipping to %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
				$calculator_text = esc_html__( 'Change address', 'woocommerce' );
			} else {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_estimate_html', __( 'Shipping options will be updated during checkout.', 'woocommerce' ) ) );
			}
			?>
		</p>
	<?php endif; ?>
	<?php
elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
	if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
		echo wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'woocommerce' ) ) );
	} else {
		echo wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woocommerce' ) ) );
	}
elseif ( ! is_cart() ) :
	echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
else :
	echo wp_kses_post(
		/**
		 * Provides a means of overriding the default 'no shipping available' HTML string.
		 *
		 * @since 3.0.0
		 *
		 * @param string $html                  HTML message.
		 * @param string $formatted_destination The formatted shipping destination.
		 */
		apply_filters(
			'woocommerce_cart_no_shipping_available_html',
			// Translators: $s shipping destination.
			sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ),
			$formatted_destination
		)
	);
	$calculator_text = esc_html__( 'Enter a different address', 'woocommerce' );
endif;
?>

<?php if ( $show_package_details ) : ?>
	<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
<?php endif; ?>

<?php if ( $show_shipping_calculator ) : ?>
	<?php woocommerce_shipping_calculator( $calculator_text ); ?>
<?php endif; ?>
