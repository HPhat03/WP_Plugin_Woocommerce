<?php
/**
 * Template for logo section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Customizer\Elements\Wishlist;
use Brandy\Utils\Helpers;

	$element    = $args['element'];
	$section_id = $element['id'];
	$settings   = $element['settings'];
	$attributes = array(
		'data-builder'    => $args['builder'],
		'data-section-id' => $section_id,
		'slide-position'  => $settings['slide_position'] ?? 'right',
	);

	$icon_style = $settings['icon_style'];
	$label      = $settings['label'];
	$devices    = brandy_get_devices();
	ob_start();
	get_template_part( Wishlist::$path_to_icons . $icon_style . '/' . $settings['icon_type'] );
	$icon = ob_get_contents();
	ob_end_clean();
	?>
<div class="brandy-wishlist-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper <?php echo esc_attr( $settings['css_classes'] ); ?>">
		<?php
		if ( 'page' === $settings['click_effect'] ) :
			$wishlist_page = '#';
			?>
			<a href="<?php echo esc_url( $wishlist_page ); ?>">
		<?php endif; ?>
		<div class="brandy-wishlist trigger-tooltip trigger-icon">
			<div class="brandy-wishlist__icon">
				<?php brandy_render_icon( $icon ); ?>
				<?php
				brandy_render_badge( apply_filters( 'brandy_wishlist_items_count', 0 ) );
				?>
			</div>
			<?php
			$label_attributes = array(
				'class' => 'brandy-wishlist-label',
			);
			$display          = $settings['label']['display'] ?? array(
				'desktop' => false,
				'tablet'  => true,
				'mobile'  => null,
			);
			if ( ! Helpers::get_device_value( $display, 'desktop' ) ) {
				$label_attributes['class'] .= ' is-tooltip';
			}
			if ( ! Helpers::get_device_value( $display, 'tablet' ) ) {
				$label_attributes['class'] .= ' hidden-md';
			}
			if ( ! Helpers::get_device_value( $display, 'mobile' ) ) {
				$label_attributes['class'] .= ' hidden-sm';
			}
			?>
			<div <?php brandy_print_dom_attributes( $label_attributes ); ?>><?php echo esc_html( $label['content'] ?? 'Wishlist' ); ?></div>
		</div>
		<?php if ( 'page' === $settings['click_effect'] ) : ?>
		</a>
		<?php endif; ?>
		<?php if ( 'dropdown' === $settings['click_effect'] ) : ?>
			<div class="brandy-wishlist-dropdown">
				<?php
				if ( function_exists( 'brandy_render_wishlist' ) ) {
					\brandy_render_wishlist( $settings );
				}
				?>
			</div>
		<?php endif; ?>
	</div>
	<?php
	if ( 'slide_in' == $settings['click_effect'] ) {
		?>
			<div class="brandy-drawer brandy-wishlist-drawer">
			<?php
			if ( function_exists( 'brandy_render_wishlist' ) ) {
				\brandy_render_wishlist( $settings );
			}
			?>
			</div>
			<div class="brandy-wishlist-overlay"></div>
			<?php
	}
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
