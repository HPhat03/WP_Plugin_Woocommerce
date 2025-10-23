<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-checkout-review-order-table woocommerce-checkout-review-order brandy-checkout-review-order">

	<div class="brandy-checkout-review-order-table">

		<?php
		/**
		 * Order items
		 */
		?>
		<?php
		/**
		 * WooCommerce hook: woocommerce_review_order_before_cart_contents.
		 */
		do_action( 'woocommerce_review_order_before_cart_contents' );

		$cart_items = WC()->cart->get_cart();

		if ( ! empty( $cart_items ) ) :
			?>
		<div class="brandy-checkout-review-order-table__row">
			<span class="brandy-checkout-review-order__label"><?php esc_html_e( 'Product', 'woocommerce' ); ?></span>
			<span class="brandy-checkout-review-order__label"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
		</div>
			<?php
		endif;

		foreach ( $cart_items as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<div class="brandy-checkout-review-order-table__row brandy-checkout-review-order-item">
					<div class="brandy-checkout-review-order-item__details">
						<div class="brandy-checkout-review-order-item__name">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
							<span class="brandy-checkout-review-order-item__quantity">
								×<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', $cart_item['quantity'], $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</div>
						<div class="brandy-checkout-review-order-item__properties">
							<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>
					<div class="brandy-checkout-review-order-item__total">
						<?php
						/**
						 * WooCommerce hook: woocommerce_cart_item_subtotal.
						 */
						echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
						?>
					</div>
				</div>
				<?php
			}
		}

		/**
		 * WooCommerce hook: woocommerce_review_order_after_cart_contents.
		 */
		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>

		<?php
		/**
		 * Subtotal
		 */
		?>
		<div class="brandy-checkout-review-order-table__row brandy-checkout-review-order-subtotal">
			<div class="brandy-checkout-review-order__label"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
			<div class="brandy-checkout-review-order__label"><?php wc_cart_totals_subtotal_html(); ?></div>
		</div>

		<?php
		/**
		 * List Coupon
		 */
		?>
		<?php
		foreach ( WC()->cart->get_coupons() as $code => $coupon ) :
			if ( is_string( $coupon ) ) {
				$coupon = new \WC_Coupon( $coupon );
			}
			$coupon_code = $coupon->get_code();
			$amount      = WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax );
			?>
			<div class="brandy-checkout-review-order-table__row brandy-checkout-review-order-coupon coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<div class="brandy-checkout-review-order__label brandy-checkout-review-order-coupon__label">
					<?php printf( esc_html__( 'Coupon: %s', 'woocommerce' ), esc_html( $coupon_code ) ); ?>
				</div>
				<div style="display: flex; align-items: center;">
					<?php
						printf(
							'<a href="%s" class="%s" data-coupon="%s">%s</a>',
							esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon_code ), \Automattic\Jetpack\Constants::is_defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ),
							'brandy-checkout-review-order-coupon__remove woocommerce-remove-coupon',
							esc_html( $coupon_code ),
							esc_html__( 'Remove', 'woocommerce' )
						)
					?>
					<span class="brandy-checkout-review-order__label brandy-checkout-review-order-coupon__amount"><?php echo wp_kses_post( \wc_price( $amount ) ); ?></span>
				</div>
			</div>
		<?php endforeach; ?>

		<?php
		/**
		 * Taxes
		 */
		?>
		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php
			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) :
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited 
					?>
					<div class="brandy-checkout-review-order-table__row brandy-checkout-review-order-coupon tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<div class="brandy-checkout-review-order-figures-item__label"><?php echo esc_html( $tax->label ); ?></div>
						<div class="brandy-checkout-review-order-figures-item__number"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
					</div>
					<?php
				endforeach;
			else :
				?>
				<div class="brandy-checkout-review-order-table__row brandy-checkout-review-order-coupon">
					<div class="brandy-checkout-review-order-figures-item__label"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></div>
					<div class="brandy-checkout-review-order-figures-item__number"><?php wc_cart_totals_taxes_total_html(); ?></div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php
		/**
		 * Fees
		 */
		?>
		<?php foreach ( \WC()->cart->get_fees() as $fee ) : ?>
				<div class="brandy-checkout-review-order-table__row brandy-checkout-review-order-fee">
					<div class="brandy-checkout-review-order-figures-item__label"><?php echo esc_html( $fee->name ); ?></div>
					<div class="brandy-checkout-review-order-figures-item__number"><?php wc_cart_totals_fee_html( $fee ); ?></div>
				</div>
			<?php endforeach; ?>
		<?php
		/**
		 * Shipping details
		 */
		?>
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<div class="brandy-checkout-review-order-table__row brandy-checkout-review-order-shipping">

				<div class="brandy-checkout-review-order-shipping-wrapper">
					<div class="brandy-checkout-review-order__label"><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></div>

					<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

					<?php wc_cart_totals_shipping_html(); ?>

					<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
				</div>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<?php
		/**
		 * Order total
		 */
		?>
		<div class="brandy-checkout-review-order-table__row brandy-checkout-review-order-total">
			<div class="brandy-checkout-review-order__label brandy-checkout-review-order-total__label"><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
			<div class="brandy-checkout-review-order__label brandy-checkout-review-order-total__number"><?php wc_cart_totals_order_total_html(); ?></div>
		</div>
		
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</div>


</div>
