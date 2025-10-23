<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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

$billing_address_fields = array_map(
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
	$checkout->get_checkout_fields( 'billing' )
);

$fields_layout = array(
	array(
		'billing_first_name',
		'billing_last_name',
	),
	array(
		'billing_company',
	),
	array(
		'billing_country',
	),
	array( 'billing_state' ),
	array(
		'billing_city',
		'billing_postcode',
	),
	array(
		'billing_address_1',
	),
	array(
		'billing_address_2',
	),
	array(
		'billing_phone',
		'billing_email',
	),
);

$outside_layout_fields = array_diff(
	array_keys( $billing_address_fields ),
	array_reduce(
		$fields_layout,
		function( $result, $row ) {
			return array_merge( $result, $row );
		},
		array()
	)
);

$exclude_fields = array( 'billing_email' );

?>
<div class="woocommerce-billing-fields">
	<h3 class="brandy-checkout-form__section-heading">
		<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>
	
			<?php esc_html_e( 'Shipping address', 'woocommerce' ); ?>
	
		<?php else : ?>
	
			<?php esc_html_e( 'Billing address', 'woocommerce' ); ?>
	
		<?php endif; ?>
	</h3>

	<?php
		/**
		 * WooCommerce hook: woocommerce_before_checkout_billing_form
		 */
		do_action( 'woocommerce_before_checkout_billing_form', $checkout );
	?>

	<?php
	/**
	 * Displaying fields based on Brandy layout
	 */
	$fields_content = '';

	foreach ( $fields_layout as $row ) {
		echo '<div class="brandy-checkout-fields__row">';
		foreach ( $row as $field_key ) {
			if ( ! isset( $billing_address_fields[ $field_key ] ) ) {
				continue;
			}
			echo '<div class="brandy-checkout-fields__column">';
			woocommerce_form_field(
				$field_key,
				$billing_address_fields[ $field_key ],
				$checkout->get_value( $field_key )
			);
			echo '</div>';

		}
		echo '</div>';
	}

	/**
	 * Displaying other fields that not existed in Brandy layout
	 */
	foreach ( $outside_layout_fields as $field_key ) {
		if ( ! isset( $billing_address_fields[ $field_key ] ) || in_array( $field_key, $exclude_fields, true ) ) {
			continue;
		}
		echo '<div class="brandy-checkout-fields__row">';
		woocommerce_form_field(
			$field_key,
			$billing_address_fields[ $field_key ],
			$checkout->get_value( $field_key )
		);
		echo '</div>';
	}
	?>

	<?php
		/**
		 * WooCommerce hook: woocommerce_after_checkout_billing_form
		 */

		do_action( 'woocommerce_after_checkout_billing_form', $checkout );
	?>
</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>
			<div class="brandy-checkout-fields__row">
				<p class="form-row form-row-wide create-account">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
					</label>
				</p>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<div class="brandy-checkout-fields__row">
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
					</div>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php

			/**
			 * WooCommerce hook: woocommerce_after_checkout_registration_form.
			 */

			do_action( 'woocommerce_after_checkout_registration_form', $checkout );

		?>
	</div>
<?php endif; ?>
