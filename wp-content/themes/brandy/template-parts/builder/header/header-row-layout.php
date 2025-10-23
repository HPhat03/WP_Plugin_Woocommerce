<?php
/**
 * Template for top header section
 *
 * @package Brandy\Templates\Header
 */

use Brandy\Utils\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$row    = isset( $args['row'] ) ? $args['row'] : 'top';
$device = isset( $args['device'] ) ? $args['device'] : 'desktop';

$section_id   = "{$row}_header";
$section_name = "$row header";

$attributes       = array(
	'data-builder'    => 'header',
	'data-section-id' => $section_id,
);
$current_template = brandy_get_header_template();

$settings = $current_template['row_configurations'][ $row ];

$is_expanded_on_mobile = isset( $settings['expand_on_mobile'] ) ? $settings['expand_on_mobile'] : true;

$hidden_classes = brandy_get_enabled_device_classes( $settings['enabled_devices'] );

if ( ! is_customize_preview() && ! in_array( $device, $settings['enabled_devices'], true ) ) {
	return;
}

$columns             = $current_template['placements'][ 'tablet' === $device ? 'mobile' : $device ][ $row ];
$row_layout          = isset( $current_template['settings']['layout'] ) ? $current_template['settings']['layout'] : 'full-width';
$columns_has_element = array_filter(
	$columns,
	function( $col ) {
		return count( $col ) > 0;
	}
);
if ( count( $columns_has_element ) <= 0 ) {
	return;
}

$attributes['id']                              = "brandy-$row-header";
$attributes['class']                           = "brandy-child-header brandy-$row-header $hidden_classes " . brandy_get_editable_class( 'row' );
$attributes['class']                          .= 'full-width' !== $row_layout ? ' is-boxed' : '';
$attributes['data-layout']                     = $row_layout;
$attributes['data-hide-stroke-when-stickying'] = ! empty( $settings['hide_stroke_when_stickying'] ) ? 'true' : 'false';
if ( ! empty( $settings['is_constrained'] ) ) {
	$attributes['data-is-constrained'] = 'true';
}

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
	$container_attributes = array(
		'class'                      => esc_attr( 'header-container ' . $row_layout ),
		'item-layout'                => esc_attr( Helpers::get_device_value( $settings['stretch_item'], $device ) ? 'stretch' : 'normal' ),
		'data-is-expanded-on-mobile' => esc_attr( $is_expanded_on_mobile ? 'true' : 'false' ),
	)
	?>
	<div class="header-container-wrapper">
		<div <?php brandy_print_dom_attributes( $container_attributes ); ?>>
			<?php do_action( 'brandy_render_header_placement', $row, $device ); ?>
		</div>
	</div>
</div>
