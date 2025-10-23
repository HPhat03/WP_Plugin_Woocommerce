<?php
/**
 * Template for top footer section
 *
 * @package Brandy\Templates\footer
 */

use Brandy\Utils\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$row    = isset( $args['row'] ) ? $args['row'] : 'top';
$device = isset( $args['device'] ) ? $args['device'] : 'desktop';

$section_id   = "{$row}_footer";
$section_name = "$row footer";

$attributes       = array(
	'data-builder'    => 'footer',
	'data-section-id' => $section_id,
);
$current_template = brandy_get_footer_template();
$device           = isset( $args['device'] ) ? $args['device'] : 'desktop';
$cols             = $current_template['placements'][ $device ][ $row ];
$cols_has_element = array_filter(
	$cols,
	function( $col ) {
		return count( $col ) > 0;
	}
);
if ( count( $cols_has_element ) <= 0 ) {
	return;
}

$settings = $current_template['row_configurations'][ $row ];

$hidden_classes = brandy_get_enabled_device_classes( $settings['enabled_devices'] );

$hidden_classes = brandy_get_enabled_device_classes( $settings['enabled_devices'] );

if ( ! is_customize_preview() && ! in_array( $device, $settings['enabled_devices'], true ) ) {
	return;
}

$row_layout = isset( $current_template['settings']['layout'] ) ? $current_template['settings']['layout'] : 'full-width';

$attributes['id']          = "brandy-$row-footer";
$attributes['class']       = "brandy-child-footer brandy-$row-footer $hidden_classes " . brandy_get_editable_class( 'row' );
$attributes['class']      .= 'full-width' !== $row_layout ? ' is-boxed' : '';
$attributes['data-layout'] = $row_layout;
if ( ! empty( $settings['is_constrained'] ) ) {
	$attributes['data-is-constrained'] = 'true';
}

// if ( ! empty( $settings['split_container'] ) ) {
// 	$attributes['data-split-container'] = 'true';
// }

?>
<div <?php brandy_print_dom_attributes( $attributes ); ?>>
	<?php
	if ( is_customize_preview() ) {
		get_template_part(
			'template-parts/common/edit-row-button',
			'',
			array(
				'part_id' => $section_id,
			)
		);
	}
	$row_attributes               = array();
	$number_col                   = Helpers::get_device_value( $settings['number_column'], $device );
	$row_attributes['number-col'] = $number_col;
	foreach ( brandy_get_devices() as $d ) {
		if ( $device === $d || ( 'mobile' === $device && 'desktop' !== $d ) ) {
			$layout = Helpers::get_device_value( $settings[ "column_layout_$number_col" ], $d );
			if ( ! isset( $settings['row_direction'] ) ) {
				$row_attributes[ "data-$d-direction" ] = 'layout_full' === $layout ? 'vertical' : 'horizontal';
			} else {
				$row_attributes[ "data-$d-direction" ] = Helpers::get_device_value( $settings['row_direction'], $d );
			}
		}
	}
		$row_attributes['class'] = esc_attr( 'footer-container ' . $row_layout );
	?>
	<div <?php brandy_print_dom_attributes( $row_attributes ); ?>>
		<?php do_action( 'brandy_render_footer_placement', $row, $device, $settings ); ?>
	</div>
</div>
