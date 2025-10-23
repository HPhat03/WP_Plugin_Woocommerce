<?php
/**
 * Template for logo section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Utils\Helpers;

	$element    = $args['element'];
	$section_id = $element['id'];
	$settings   = $element['settings'];
	$attributes = array(
		'data-builder'    => $args['builder'],
		'data-section-id' => $section_id,
	);
	?>
<div class="brandy-divider-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<?php
	$divider_attributes = array();
	foreach ( brandy_get_devices() as $device ) {
		$divider_attributes[ 'data-' . $device . '-layout' ] = Helpers::get_device_value( $settings['layout'], $device );
	}
	?>
	<div class="brandy-element-wrapper brandy-divider" <?php brandy_print_dom_attributes( $divider_attributes ); ?>></div>
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
