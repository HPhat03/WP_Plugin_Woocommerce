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
$menu_name  = $settings['menu_name'];
$items      = wp_get_nav_menu_items( $menu_name );

?>
<div class="brandy-menu-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<?php
	$wrapper_attributes   = array();
	$items_direction      = $settings['items_direction'];
	$horizontal_alignment = $settings['horizontal_alignment'];
	foreach ( brandy_get_devices() as $device ) {
		$wrapper_attributes[ "layout-$device" ]    = Helpers::get_device_value( $items_direction, $device );
		$wrapper_attributes[ "alignment-$device" ] = Helpers::get_device_value( $horizontal_alignment, $device );
	}
	?>
		<div class="brandy-element-wrapper" <?php brandy_print_dom_attributes( $wrapper_attributes ); ?>>
		<div class="brandy-menu-title"><?php echo esc_html( $settings['menu_title_text'] ); ?></div>
		<?php
		wp_nav_menu(
			array(
				'menu'       => $menu_name,
				'menu_id'    => $element['id'],
				'items_wrap' => "<ul role='menubar' id='" . $element['id'] . "' class='brandy-menu brandy-menu-items'>%3\$s</ul>",
				'depth'      => '1',
				'walker'     => new \Brandy\Utils\Walkers\MenuWalker( $settings, null, 1 ),
				'menu_class' => '',
				'container'  => 'ul',
				'before'     => "<ul role='menubar' id='" . $element['id'] . "' class='brandy-menu brandy-menu-items'>",
				'after'      => '</ul>',
			)
		);
		?>
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

