<?php
/**
 * Template for socials section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Customizer\Elements\BaseSocials;
use Brandy\Utils\Helpers;

$element         = $args['element'];
$section_id      = $element['id'];
$settings        = $element['settings'];
$attributes      = array(
	'data-builder'    => $args['builder'],
	'data-section-id' => $section_id,
);
$items           = $settings['items'];
$icon_color_type = $settings['icon_color_type'];
$target          = $settings['target'];
?>
<div class="brandy-socials-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper">
		<div class="brandy-social-title"><?php echo esc_html( $settings['title_text'] ?? '' ); ?></div>
		<div class="brandy-social-list">
			<?php
			foreach ( $items as $item ) :
				ob_start();
				$icon_path = BaseSocials::$path_to_icons . $item['icon'] . '/' . $icon_color_type;
				if ( isset( $args['device'] ) && 'desktop' !== $args['device'] && 'instagram' === $item['icon'] && 'custom' !== $icon_color_type ) {
					$icon_path .= '-tablet';
				}
				get_template_part( $icon_path );
				$icon = ob_get_contents();
				ob_end_clean();
				$item_attributes = array(
					'href'           => esc_url( $item['url'] ),
					'data-social-id' => esc_attr( $item['id'] ),
					'data-icon'      => esc_attr( $item['icon'] ),
					'aria-label'     => esc_html( $item['label'] ),
					'target'         => esc_attr( $settings['target'] ? '_blank' : '_self' ),
				)
				?>
				<a class="brandy-social-item <?php echo esc_attr( ! $item['visible'] ? 'hidden' : '' ); ?>" <?php brandy_print_dom_attributes( $item_attributes ); ?>>
					<span class="brandy-social-item__icon" color-type=<?php echo esc_attr( $icon_color_type ); ?>>
						<?php
						if ( 'default' === $icon_color_type ) {
							echo $icon;
						} else {
							brandy_render_icon( $icon );
						}
						?>
					</span>
					<span class="brandy-social-item__label"><?php echo esc_html( $item['label'] ); ?></span>
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
