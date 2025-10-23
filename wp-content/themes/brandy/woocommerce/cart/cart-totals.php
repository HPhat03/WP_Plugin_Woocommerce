<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals cart-totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h4 class="cart-totals__title"><?php esc_html_e( 'Order summary', 'woocommerce' ); ?></h4>

	<div class="cart-totals__information">
		<div class="cart-totals__information-group">
			<div class="cart-totals__item cart-subtotal">
				<span class="cart-totals__item__label"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
				<span class="cart-totals__item__content"><?php wc_cart_totals_subtotal_html(); ?></span>
			</div>
			<?php
			$cart_coupons = WC()->cart->get_coupons();
			if ( ! empty( $cart_coupons ) ) :
				$total_coupon_amount = 0;
				?>
			<div class="cart-coupons cart-totals__item">
				<span class="cart-totals__item__label"><?php esc_html_e( 'Discounts', 'woocommerce' ); ?></span>
				<div class="brandy-coupons">
					<div class="brandy-coupon-list">
						<?php
						foreach ( $cart_coupons as $code => $coupon ) :
							if ( is_string( $coupon ) ) {
								$coupon = new WC_Coupon( $coupon );
							}
							$coupon_code          = $coupon->get_code();
							$amount               = WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax );
							$total_coupon_amount += $amount;
							?>
							<div class="brandy-coupon-item coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
								<span><?php echo esc_html( $coupon_code ); ?></span>
								<?php
								printf(
									'<a href="%s" class="%s" data-coupon="%s">%s</a>',
									esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon_code ), \Automattic\Jetpack\Constants::is_defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ),
									'brandy-coupon-item__remove woocommerce-remove-coupon',
									esc_html( $coupon_code ),
									'<svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.85211 6.85211C7.04902 6.65521 7.04902 6.33596 6.85211 6.13906L4.71337 4.00032L6.85286 1.86084C7.04976 1.66393 7.04976 1.34469 6.85286 1.14778C6.65595 0.950878 6.33671 0.950878 6.1398 1.14778L4.00032 3.28727L1.86073 1.14768C1.66383 0.950774 1.34458 0.950774 1.14768 1.14768C0.950774 1.34458 0.950774 1.66383 1.14768 1.86073L3.28726 4.00032L1.14842 6.13916C0.951519 6.33607 0.951519 6.65531 1.14842 6.85221C1.34533 7.04912 1.66457 7.04912 1.86148 6.85221L4.00032 4.71337L6.13906 6.85211C6.33596 7.04902 6.65521 7.04902 6.85211 6.85211Z" fill="#272829"/><path d="M6.85211 6.13906L6.7814 6.20977L6.85211 6.13906ZM4.71337 4.00032L4.64266 3.92961L4.57195 4.00032L4.64266 4.07103L4.71337 4.00032ZM6.85286 1.86084L6.78215 1.79013L6.85286 1.86084ZM6.85286 1.14778L6.78215 1.21849V1.21849L6.85286 1.14778ZM6.1398 1.14778L6.21051 1.21849L6.21051 1.21849L6.1398 1.14778ZM4.00032 3.28727L3.92961 3.35798L4.00032 3.42869L4.07103 3.35798L4.00032 3.28727ZM1.86073 1.14768L1.93144 1.07697V1.07697L1.86073 1.14768ZM1.14768 1.14768L1.21839 1.21839L1.14768 1.14768ZM1.14768 1.86073L1.07697 1.93144L1.14768 1.86073ZM3.28726 4.00032L3.35798 4.07103L3.42869 4.00032L3.35798 3.92961L3.28726 4.00032ZM1.14842 6.13916L1.07771 6.06845H1.07771L1.14842 6.13916ZM1.14842 6.85221L1.21913 6.7815H1.21913L1.14842 6.85221ZM1.86148 6.85221L1.79077 6.7815H1.79077L1.86148 6.85221ZM4.00032 4.71337L4.07103 4.64266L4.00032 4.57195L3.92961 4.64266L4.00032 4.71337ZM6.13906 6.85211L6.06835 6.92282L6.13906 6.85211ZM6.7814 6.20977C6.93925 6.36762 6.93925 6.62355 6.7814 6.7814L6.92282 6.92282C7.15878 6.68687 7.15878 6.3043 6.92282 6.06835L6.7814 6.20977ZM4.64266 4.07103L6.7814 6.20977L6.92282 6.06835L4.78408 3.92961L4.64266 4.07103ZM6.78215 1.79013L4.64266 3.92961L4.78408 4.07103L6.92357 1.93155L6.78215 1.79013ZM6.78215 1.21849C6.94 1.37635 6.94 1.63227 6.78215 1.79013L6.92357 1.93155C7.15952 1.69559 7.15952 1.31303 6.92357 1.07707L6.78215 1.21849ZM6.21051 1.21849C6.36836 1.06064 6.62429 1.06064 6.78215 1.21849L6.92357 1.07707C6.68761 0.841115 6.30505 0.841115 6.06909 1.07707L6.21051 1.21849ZM4.07103 3.35798L6.21051 1.21849L6.06909 1.07707L3.92961 3.21655L4.07103 3.35798ZM1.79002 1.21839L3.92961 3.35798L4.07103 3.21655L1.93144 1.07697L1.79002 1.21839ZM1.21839 1.21839C1.37624 1.06054 1.63217 1.06054 1.79002 1.21839L1.93144 1.07697C1.69549 0.841011 1.31292 0.841011 1.07697 1.07697L1.21839 1.21839ZM1.21839 1.79002C1.06054 1.63217 1.06054 1.37624 1.21839 1.21839L1.07697 1.07697C0.841011 1.31292 0.841011 1.69549 1.07697 1.93144L1.21839 1.79002ZM3.35798 3.92961L1.21839 1.79002L1.07697 1.93144L3.21655 4.07103L3.35798 3.92961ZM1.21913 6.20987L3.35798 4.07103L3.21655 3.92961L1.07771 6.06845L1.21913 6.20987ZM1.21913 6.7815C1.06128 6.62365 1.06128 6.36772 1.21913 6.20987L1.07771 6.06845C0.841756 6.30441 0.841755 6.68697 1.07771 6.92293L1.21913 6.7815ZM1.79077 6.7815C1.63291 6.93936 1.37699 6.93936 1.21913 6.7815L1.07771 6.92293C1.31367 7.15888 1.69623 7.15888 1.93219 6.92293L1.79077 6.7815ZM3.92961 4.64266L1.79077 6.7815L1.93219 6.92293L4.07103 4.78408L3.92961 4.64266ZM6.20977 6.7814L4.07103 4.64266L3.92961 4.78408L6.06835 6.92282L6.20977 6.7814ZM6.7814 6.7814C6.62355 6.93925 6.36762 6.93925 6.20977 6.7814L6.06835 6.92282C6.3043 7.15878 6.68686 7.15878 6.92282 6.92282L6.7814 6.7814Z" fill="#272829"/></svg>'
								);
								?>
							</div>
						<?php endforeach; ?>
					</div>
					<span class="brandy-coupons-total"><?php echo wp_kses_post( wc_price( $total_coupon_amount ) ); ?></span>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<div class="cart-totals__information-group">

			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

				<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

				<?php wc_cart_totals_shipping_html(); ?>

				<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

			<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

				<div class="cart-totals__item shipping">
					<span><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></span>
					<span data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></span>
				</div>
			<?php else : ?>
				<?php esc_html_e( 'No shipping available', 'woocommerce' ); ?>
			<?php endif; ?>
		</div>
		<?php
		$cart_fees = WC()->cart->get_fees();
		if ( count( $cart_fees ) > 0 ) :
			?>
		<div class="cart-totals__information-group">
			<?php foreach ( $cart_fees as $fee ) : ?>
				<div class="cart-totals__item fee">
					<span><?php echo esc_html( $fee->name ); ?></span>
					<span data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<?php
		$tax_content = '';
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			ob_start();
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				/* translators: %s location. */
				$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					?>
					<div class="cart-totals__item tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<span><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
					</div>
					<?php
				}
			} else {
				?>
				<div class="cart-totals__item tax-total">
					<span><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></span>
				</div>
				<?php
			}
			$tax_content = ob_get_contents();
			?>
			<?php
			ob_end_clean();
		}
		?>
		<?php if ( ! empty( $tax_content ) ) : ?>
			<div class="cart-totals__information-group">
				<?php echo $tax_content; //PHPCS:ignore ?>
			</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<div class="cart-totals__item order-total">
			<span><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
			<span data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></span>
		</div>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</div>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
