<?php
/**
 * Template for toggle off canvas section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Builder\Header\ToggleOffCanvasBuilder;

	$current_template = brandy_get_header_template();
	$settings         = $current_template['row_configurations']['toggle'];
	$section_id       = 'toggle_off_canvas';
	$attributes       = array(
		'data-builder'    => 'header',
		'data-section-id' => $section_id,
	);

	$attributes['horizontal-alignment'] = $settings['horizontal_align'] ?? 'left';
	$canvas_type                        = $settings['canvas_type'];
	?>
<div id="toggle-off-canvas" type=<?php echo esc_attr( $canvas_type ); ?> class="brandy-toc-section <?php echo esc_attr( brandy_get_editable_class( 'row' ) ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<?php
	if ( 'dropdown_panel' === $canvas_type ) {
		ToggleOffCanvasBuilder::render_close_icon();
	}
	?>
	<div class="brandy-toc-panel">
		<?php
		if ( 'dropdown_panel' !== $canvas_type ) {
			ToggleOffCanvasBuilder::render_close_icon();
		}
		?>
		<?php
		foreach ( array( 'desktop', 'mobile' ) as $device ) :
			if ( $args['device'] !== $device ) {
				continue;
			}
			?>
			<div class="brandy-toc-elements-wrapper" device=<?php echo esc_attr( $device ); ?>>
				<?php ToggleOffCanvasBuilder::render_elements( $device ); ?>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="brandy-toc-backdrop"></div>
</div>
