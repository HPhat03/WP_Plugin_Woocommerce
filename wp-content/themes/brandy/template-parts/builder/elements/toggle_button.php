<?php
/**
 * Template for logo section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Customizer\Elements\ToggleButton;

	$element    = $args['element'];
	$section_id = $element['id'];
	$settings   = $element['settings'];
	$attributes = array(
		'data-builder'    => $args['builder'],
		'data-section-id' => $section_id,
	);

	$button_text          = isset( $settings['text']['value'] ) ? $settings['text']['value'] : 'MENU';
	$button_text_enabled  = isset( $settings['text']['enabled'] ) ? $settings['text']['enabled'] : false;
	$button_text_position = isset( $settings['text']['position'] ) ? $settings['text']['position'] : 'right';
	?>
<div class="brandy-toggle-button-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper">
		<div class="brandy-toggle-button">
			<div class="brandy-toggle-button--open">
				<?php brandy_render_icon( ToggleButton::get_icon( $settings['button_type'] ) ); ?>
			</div>
			<div class="brandy-toggle-button--close">
				<div class="brandy-theme-icon">
					<div class="absolute bg-black2 h-[2px] w-5 transform transition-all duration-500 delay-300 rotate-45"></div>
					<div class="absolute bg-black2 h-[2px] w-5 transform transition-all duration-500 delay-300 -rotate-45"></div>
				</div>
			</div>
		</div>
		<?php if ( $button_text_enabled ) : ?>
		<span class="brandy-toggle-button__text" data-position=<?php esc_attr( $button_text_position ); ?>><?php echo esc_html( $button_text ); ?></span>
		<?php endif; ?>
	</div>
	<?php
		do_action( 'brandy_toggle_off_canvas', $args );
	?>
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
