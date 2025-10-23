<?php
/**
 * Template for button section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Core\Services\StringVariablesService;
use Brandy\Customizer\Elements\BaseButton;

	$element    = $args['element'];
	$section_id = $element['id'];
	$settings   = $element['settings'];
	$attributes = array(
		'data-builder'    => $args['builder'],
		'data-section-id' => $section_id,
	);

	$button_icon = BaseButton::get_icon( $settings['icon'] );

	$extra_class = '';

	$button_class  = '';
	$inherit_theme = $settings['inherit_theme'] ?? true;

	if ( 'outline' === $settings['type'] && $inherit_theme ) {
		$extra_class .= 'is-style-outline is-style-outline--1 wp-block-button';
		$button_class = 'wp-element-button wp-block-button__link';
	}
	if ( 'fill' === $settings['type'] && $inherit_theme ) {
		$extra_class .= 'wp-block-button';
		$button_class = 'wp-element-button';
	}

	if ( ! $inherit_theme ) {
		$extra_class .= 'brandy-custom-button';
	}

	?>
<div class="brandy-button-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper<?php echo esc_attr( ! empty( $extra_class ) ? " $extra_class" : '' ); ?>" data-type="<?php echo esc_attr( $settings['type'] ?? 'fill' ); ?>">
	<?php
		$button_attributes = array(
			'target' => $settings['link_new_tab'] ? '_blank' : '_self',
			'href'   => esc_url( StringVariablesService::replace_variables( $settings['link'] ) ),
		);
		?>
		<a class="brandy-button <?php echo esc_attr( $button_class ); ?>" <?php brandy_print_dom_attributes( $button_attributes ); ?>>
			<?php
			if ( $settings['icon_enabled'] ) {
				echo $button_icon;
			}
			?>
			<span class="brandy-button-text-wrap">
			<?php echo esc_html( $settings['text'] ); ?>
			</span>
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
