<?php
/**
 * Template for logo section
 *
 * @package Brandy\Templates\Builder\Elements
 */

$element          = $args['element'];
$section_id       = $element['id'];
$settings         = $element['settings'];
$attributes       = array(
	'data-builder'    => $args['builder'],
	'data-section-id' => $section_id,
);
$menu_name        = brandy_get_nav_menu_name( isset( $settings['menu_name'] ) ? $settings['menu_name'] : '' );
$active_item_type = $settings['active_type'];

?>
<div class="brandy-menu-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<?php
	$layout             = ! empty( $args['in_toggle'] ) ? 'vertical' : 'horizontal';
	$wrapper_attributes = array(
		'layout'          => $layout,
		'data-overlapped' => $settings['menu_overlapped'] ?? 'more-options',
	);
	?>
	<div class="brandy-element-wrapper" <?php brandy_print_dom_attributes( $wrapper_attributes ); ?>>
		<?php
			$back_icon  = '<span class="menu-navigation__back"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 10L4 10" stroke="#1E1E1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 4L4 10L10 16" stroke="#1E1E1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
			$navigation = "<div class='brandy-menu-navigation'>" . $back_icon . "<span class='menu-mavigation-text'></span></div>";
			wp_nav_menu(
				array(
					'menu'       => $menu_name,
					'menu_id'    => $element['id'],
					'items_wrap' => ( 'vertical' === $layout ? $navigation : '' ) . "<ul id='" . $element['id'] . "' class='brandy-menu brandy-menu-items' role='menubar' active-type='" . esc_attr( $active_item_type ) . "'>%3\$s</ul>",
					'depth'      => '4',
					'walker'     => new \Brandy\Utils\Walkers\MenuWalker( $settings, $layout ),
					'menu_class' => '',
					'container'  => 'ul',
					'before'     => ( 'vertical' === $layout ? $navigation : '' ) . "<ul id='" . $element['id'] . "' class='brandy-menu brandy-menu-items' role='menubar' active-type='" . esc_attr( $active_item_type ) . "'>",
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
