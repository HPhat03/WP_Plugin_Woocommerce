<?php
/**
 * Template for account section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Customizer\Elements\Account;
use Brandy\Utils\Helpers;

if ( empty( $args['element'] ) ) {
	return;
}

$element    = $args['element'];
$section_id = $element['id'];
$attributes = array(
	'class'           => 'brandy-account-element ' . esc_attr( brandy_get_editable_class() ),
	'data-builder'    => $args['builder'],
	'data-section-id' => $section_id,
);
$settings   = $element['settings'];

if ( empty( $settings ) ) {
	return;
}

$current_state = Account::get_state();

$account_data = array(
	'icon'           => Account::get_account_icon( $settings ),
	'label'          => Account::get_account_label( $settings ),
	'account_link'   => Account::get_account_link( $settings ),
	'icon_style'     => $settings[ $current_state ]['icon_style'] ?? 'outline',
	'display_type'   => $settings[ $current_state ]['display_type'] ?? 'icon',
	'label_position' => $settings[ $current_state ]['label_position'] ?? 'right',
	'label_enable'   => $settings[ $current_state ]['label_enable'] ?? array(
		'desktop' => false,
		'tablet'  => true,
		'mobile'  => null,
	),
);
?>
<div <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper">
		<?php
		$wrapper_attributes = array(
			'class'      => 'brandy-account trigger-tooltip trigger-icon',
			'aria-label' => Account::LOGGED_IN_STATE === $current_state ? 'View account' : 'Login',
			'href'       => $account_data['account_link'],
			'in-toggle'  => ( $args['in_toggle'] ?? false ) ? 'true' : 'false',
		);
		?>
		<a <?php brandy_print_dom_attributes( $wrapper_attributes ); ?>>
			<?php if ( 'text' !== $account_data['display_type'] ) : ?>
				<?php
				brandy_render_icon(
					$account_data['icon'],
					array( 'class' => 'brandy-account__icon' )
				);
				?>
			<?php endif; ?>
			<?php
			$label_attributes = array(
				'class' => 'brandy-account__label',
			);
			if ( ! Helpers::get_device_value( $account_data['label_enable'], 'desktop' ) ) {
				$label_attributes['class'] .= ' is-tooltip';
			}
			if ( ! Helpers::get_device_value( $account_data['label_enable'], 'tablet' ) ) {
				$label_attributes['class'] .= ' hidden-md';
			}
			if ( ! Helpers::get_device_value( $account_data['label_enable'], 'mobile' ) ) {
				$label_attributes['class'] .= ' hidden-sm';
			}
			?>
			<?php if ( is_customize_preview() || ! empty( $account_data['label'] ) ) : ?>
				<div <?php brandy_print_dom_attributes( $label_attributes ); ?>>
					<?php echo wp_kses_post( $account_data['label'] ); ?>
				</div>
			<?php endif; ?>
		</a>
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
