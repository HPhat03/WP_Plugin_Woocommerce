<?php
/**
 * Template for currency section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Customizer\Elements\Currency;

 //TODO:AT HOME
//  Show currency icon
//  Icon Position
//  Show arraw icon
// Design:
// Currency icon
// Currency codes
// Icon arrow
// Item Spacing

$element    = $args['element'];
$section_id = $element['id'];
$settings   = $element['settings'];
$attributes = array(
	'data-builder'    => $args['builder'],
	'data-section-id' => $section_id,
);

if ( ! function_exists( 'brandy_currency_dropdown' ) ) {
	function brandy_currency_dropdown( $settings, $echo = true ) {
		$currency_icon_position = isset( $settings['currency_icon_position'] ) ? $settings['currency_icon_position'] : 'left';
		if ( ! class_exists( '\Yay_Currency\Helpers\Helper' ) || ! class_exists( '\Yay_Currency\Helpers\YayCurrencyHelper' ) ) {
			return '';
		}

		$selected_currency_ID = apply_filters( 'yay_currency_get_id_selected_currency', \Yay_Currency\Helpers\YayCurrencyHelper::get_id_selected_currency() );
		$selected_currency    = null;

		$currencies = apply_filters( 'yay_currency_get_currencies_posts', \Yay_Currency\Helpers\Helper::get_currencies_post_type() );

		foreach ( $currencies as $cur ) {
			if ( $cur->ID == $selected_currency_ID ) {
				$selected_currency = $cur;
				break;
			}
		}
		if ( is_null( $selected_currency ) ) {
			$selected_currency = $currencies[0];
		}
		$html = '';
		ob_start();
		?>
		<div class="brandy-element-wrapper relative">
			<div class="brandy-currency-switcher__placeholder">
				<div class="brandy-currency-box" flag-position=<?php echo esc_attr( $currency_icon_position ); ?>>
					<?php if ( is_customize_preview() || ( $settings['currency_flag_enabled'] ?? true ) ) : ?>
						<span class="brandy-currency-flag">
							<img src="<?php echo esc_url( Currency::get_currency_flag( $selected_currency->post_title ) ); ?>" alt="currency-flag">
						</span>
					<?php endif; ?>
					<span class="brandy-currency-name"><?php echo esc_html( $selected_currency->post_title ); ?></span>
				</div>
				<?php if ( is_customize_preview() || ( $settings['show_arrow_icon'] ?? true ) ) : ?>
					<div class="brandy-currency-arrow">⌃</div>
				<?php endif; ?>
			</div>
			<div class="brandy-currency-options">
				<?php

				foreach ( $currencies as $currency ) {
					?>
					<div class="brandy-currency-option <?php echo esc_attr( $selected_currency_ID == $currency->ID ? 'current-currency' : '' ); ?>" data-yay_id="<?php echo esc_attr( $currency->ID ); ?>" data-currency="<?php echo esc_attr( $currency->post_title ); ?>">
						<div class="brandy-currency-box" flag-position=<?php echo esc_attr( $currency_icon_position ); ?>>
							<?php if ( is_customize_preview() || ( $settings['currency_flag_enabled'] ?? true ) ) : ?>
								<span class="brandy-currency-flag">
									<img src="<?php echo esc_url( Currency::get_currency_flag( $currency->post_title ) ); ?>" alt="currency-flag">
								</span>
							<?php endif; ?>
							<span class="brandy-currency-name"><?php echo esc_html( $currency->post_title ); ?></span>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			</div>
		<?php
		$html = ob_get_contents();
		ob_end_clean();
		if ( $echo ) {
			echo $html; //PHPCS: XSS ok.
		} else {
			return $html;
		}
	}
}
if ( ! function_exists( 'brandy_yaycurrency_form' ) ) {
	function brandy_yaycurrency_form() {
		if ( ! class_exists( '\Yay_Currency\Helpers\Helper' ) || ! class_exists( '\Yay_Currency\Helpers\YayCurrencyHelper' ) ) {
			return '';
		}
		$selected_currencies     = apply_filters( 'yay_currency_get_currencies_posts', \Yay_Currency\Helpers\Helper::get_currencies_post_type() );
		$selected_currency_ID    = apply_filters( 'yay_currency_get_id_selected_currency', \Yay_Currency\Helpers\YayCurrencyHelper::get_id_selected_currency() );
		$yay_currency_use_params = \Yay_Currency\Helpers\Helper::use_yay_currency_params();
		$name                    = $yay_currency_use_params ? 'yay_currency' : 'currency';

		?>
		<form action-xhr="<?php echo esc_url( get_home_url() ); ?>" method='POST' class='yay-currency-form-switcher brandy-yay-currency-form'>
			<?php \Yay_Currency\Helpers\Helper::create_nonce_field(); ?>
			<select class='yay-currency-switcher' name='<?php echo esc_attr( $name ); ?>' onchange='this.form.submit()'>
				<?php
				foreach ( $selected_currencies as $currency ) {
					echo '<option value="' . esc_attr( $currency->ID ) . '" ' . selected( $selected_currency_ID, $currency->ID, false ) . '></option>';
				}
				?>
			</select>
		</form>
		<?php
	}
}
?>
<div class="brandy-currency-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper">
		<?php
		if ( ! is_customize_preview() ) {
			brandy_yaycurrency_form();
		}
		?>
		<div class="brandy-currency">
			<?php
			if ( is_array( $settings['currencies'] ) && count( $settings['currencies'] ) > 0 ) {
				brandy_currency_dropdown( $settings );
			}

			?>
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
</div>
