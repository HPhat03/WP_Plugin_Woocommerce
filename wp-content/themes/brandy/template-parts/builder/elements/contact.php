<?php
/**
 * Template for contact section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Customizer\Elements\Contact;
use Brandy\Utils\Helpers;

$element    = $args['element'];
$section_id = $element['id'];
$settings   = $element['settings'];
$attributes = array(
	'data-builder'    => $args['builder'],
	'data-section-id' => $section_id,
);

$items = isset( $settings['items'] ) ? $settings['items'] : array();

?>
<div class="brandy-contact-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper">
		<?php
			$list_attributes = array();
		foreach ( brandy_get_devices() as $device ) {
			$list_attributes[ "items-direction-$device" ] = Helpers::get_device_value( $settings['items_direction'], $device );
		}
		?>
		<div class="brandy-contact-list" <?php brandy_print_dom_attributes( $list_attributes ); ?>>
			<?php
			foreach ( $items as $item ) :
				ob_start();
				get_template_part( Contact::$path_to_icons . $item['icon'] );
				$icon = ob_get_contents();
				ob_end_clean();
				?>
				<a class="brandy-contact-item <?php echo esc_attr( ! $item['visible'] ? 'hidden' : '' ); ?>" type=<?php echo esc_attr( $item['id'] ); ?> href="<?php echo esc_url( $item['url'] ); ?>" data-social-id=<?php echo esc_attr( $item['id'] ); ?> data-icon=<?php echo esc_attr( $item['icon'] ); ?> aria-label="<?php echo esc_html( $item['label'] ); ?>" target="<?php echo esc_attr( $settings['target'] ? '_blank' : '_self' ); ?>">
					<span class="brandy-contact-item__icon" >
						<?php brandy_render_icon( $icon ); ?>
					</span>
					<span class="brandy-contact-item__text"><?php echo esc_html( $item['content'] ); ?></span>
				</a>
				<?php
			endforeach;
			?>
		</div>
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
