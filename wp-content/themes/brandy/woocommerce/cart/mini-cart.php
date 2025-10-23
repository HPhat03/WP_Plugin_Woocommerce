<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="brandy-mini-cart-wrapper">
	<?php $items_count = WC()->cart->get_cart_contents_count(); ?>
	<div class="brandy-mini-cart-top">
		<?php // Translators: %s cart items number. ?>
		<div class="brandy-mini-cart__title">
			<h2 class="brandy-mini-cart__title__text"><?php echo wp_kses_post( sprintf( __( 'Your cart (%s)', 'brandy' ), $items_count ) ); ?></h2>
			<button class="brandy-mini-cart__close" type="button" tabindex="0" title="Close mini cart"><span class="sr-only">Close panel</span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg></button>
		</div>
		<div class="brandy-mini-cart__content">
			<?php do_action( 'woocommerce_before_mini_cart' ); ?>

			<?php if ( ! WC()->cart->is_empty() ) : ?>

				<ul class="woocommerce-mini-cart cart_list product_list_widget brandy-mini-cart__list <?php echo esc_attr( $args['list_class'] ); ?>">
					<?php
					do_action( 'woocommerce_before_mini_cart_contents' );

					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							/**
							 * This filter is documented in woocommerce/templates/cart/cart.php.
							 *
							 * @since 2.1.0
							 */
							$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
							$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
							$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							global $brandy_cart_settings;
							$click_effect = $brandy_cart_settings['click_effect'] ?? 'slide_in';
							?>
							<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?> brandy-mini-cart__item">
								<div class="item-thumbnail">
									<?php if ( empty( $product_permalink ) ) : ?>
										<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php else : ?>
										<a href="<?php echo esc_url( $product_permalink ); ?>" aria-label="<?php echo esc_html( $product_name ); ?>">
											<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</a>
									<?php endif; ?>
								</div>
								<div class="item-details">
									<div class="item-name brandy-link-underline">
										<?php
										if ( empty( $product_permalink ) ) {
											echo wp_kses_post( $product_name );
										} else {
											echo sprintf( "<a href='%s' alt='item-name'>%s</a>", esc_url( $product_permalink ), wp_kses_post( $product_name ) );
										}
										?>
									</div>
									<?php $cart_data = wc_get_formatted_cart_item_data( $cart_item ); ?>
									<?php if ( ! empty( $cart_data ) ) : ?>
										<div class="item-description"><?php echo wp_kses_post( $cart_data ); ?></div>
									<?php endif; ?>
									<div class="item-actions">
										<?php if ( 'slide_in' === $click_effect ) : ?>
										<div class="item-figure mini-cart-slide-figure">
											<?php
											if ( $_product->is_sold_individually() ) {
												$min_quantity = 1;
												$max_quantity = 1;
											} else {
												$min_quantity = 0;
												$max_quantity = $_product->get_max_purchase_quantity();
											}
											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $max_quantity,
													'min_value'    => $min_quantity,
													'product_name' => $product_name,
												),
												$_product,
												false
											);

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); //PHPCS: XSS ok.
											?>
											<div class="item-price"><?php echo wp_kses_post( $product_price ); ?></div>
										</div>
										<?php endif; ?>
										<?php if ( 'dropdown' === $click_effect ) : ?>
										<div class="item-figure mini-cart-dropdown-figure">
											<div class="item-price"><?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
										</div>
										<?php endif; ?>
										<div class="item-remove">
										<?php
										echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											'woocommerce_cart_item_remove_link',
											sprintf(
												'<span class="remove_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="none" viewBox="0 0 16 18"><g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"><path d="M13.721 6.92c0 6.942 1 10.08-5.73 10.08s-5.71-3.138-5.71-10.08M15 4.26H1M10.97 4.26S11.43 1 8 1C4.575 1 5.033 4.26 5.033 4.26"></path></g></svg></span>',
												/* translators: %s is the product name */
												esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
												esc_attr( $product_id ),
												esc_attr( $cart_item_key ),
												esc_attr( $_product->get_sku() )
											),
											$cart_item_key
										);
										?>
										</div>
									</div>
								</div>
							</li>
							<?php
						}
					}

					do_action( 'woocommerce_mini_cart_contents' );
					?>
				</ul>

			<?php else : ?>

				<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

			<?php endif; ?>
			<?php
			do_action( 'woocommerce_after_mini_cart' );
			?>
		</div>
	</div>
	<?php if ( ! WC()->cart->is_empty() ) : ?>
		<div class="brandy-mini-cart-bottom">
			<p class="woocommerce-mini-cart__total total brandy-mini-cart__total">
				<?php
				/**
				 * Hook: woocommerce_widget_shopping_cart_total.
				 *
				 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
				 */
				do_action( 'woocommerce_widget_shopping_cart_total' );
				?>
			</p>

			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

			<div class="woocommerce-mini-cart__buttons buttons brandy-mini-cart__buttons">
				<?php
				brandy_render_link_button(
					array(
						'href'  => wc_get_checkout_url(),
						'text'  => esc_html__(
							'Checkout',
							'woocommerce'
						),
						'class' => 'w-full text-center checkout',
					)
				);
				?>
				<?php echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="wc-forward view-cart">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>'; ?>
				<?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
			</div>
			<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
		</div>
		<?php
	endif;
	?>
	
</div>
