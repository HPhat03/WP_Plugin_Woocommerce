<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

$shipping_address_fields = array_map(
	function( $field ) {
		$field['placeholder'] = empty( $field['placeholder'] ) ? $field['label'] : $field['placeholder'];
		$field['class']       = array_filter(
			$field['class'],
			function( $class_name ) {
				return ! in_array( $class_name, array( 'form-row-wide', 'form-row-first', 'form-row-last' ), true );
			}
		);

		return $field;
	},
	$checkout->get_checkout_fields( 'shipping' )
);

$fields_layout = array(
	array(
		'shipping_first_name',
		'shipping_last_name',
	),
	array(
		'shipping_company',
	),
	array(
		'shipping_country',
	),
	array( 'shipping_state' ),
	array(
		'shipping_city',
		'shipping_postcode',
	),
	array(
		'shipping_address_1',
	),
	array(
		'shipping_address_2',
	),
	array(
		'shipping_phone',
		'shipping_email',
	),
);

$outside_layout_fields = array_diff(
	array_keys( $shipping_address_fields ),
	array_reduce(
		$fields_layout,
		function( $result, $row ) {
			return array_merge( $result, $row );
		},
		array()
	)
);

$exclude_fields = array();

?>
<div class="woocommerce-shipping-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<div id="ship-to-different-address" class="brandy-checkout-fields__row">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
			</label>
		</div>

		
		<div class="shipping_address">
			
			<h3 class="brandy-checkout-form__section-heading"><?php esc_html_e( 'Shipping details', 'woocommerce' ); ?></h3>

			<?php
				/**
				 * WooCommerce hook: woocommerce_before_checkout_shipping_form
				 */
				do_action( 'woocommerce_before_checkout_shipping_form', $checkout );
			?>

			<?php
			foreach ( $fields_layout as $row ) {
				echo '<div class="brandy-checkout-fields__row">';
				foreach ( $row as $field_key ) {
					if ( ! isset( $shipping_address_fields[ $field_key ] ) ) {
						continue;
					}
					echo '<div class="brandy-checkout-fields__column">';
					woocommerce_form_field(
						$field_key,
						$shipping_address_fields[ $field_key ],
						$checkout->get_value( $field_key )
					);
					echo '</div>';

				}
				echo '</div>';
			}

			foreach ( $outside_layout_fields as $field_key ) {
				if ( ! isset( $shipping_address_fields[ $field_key ] ) || in_array( $field_key, $exclude_fields, true ) ) {
					continue;
				}
				echo '<div class="brandy-checkout-fields__row">';
				woocommerce_form_field(
					$field_key,
					$shipping_address_fields[ $field_key ],
					$checkout->get_value( $field_key )
				);
				echo '</div>';
			}
			?>

			<?php
				/**
				 * WooCommerce hook: woocommerce_after_checkout_shipping_form.
				 */
				do_action( 'woocommerce_after_checkout_shipping_form', $checkout );
			?>

		</div>

	<?php endif; ?>
</div>
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<div class="brandy-checkout-fields__row">
					<div class="brandy-checkout-fields__column">
						<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
