<?php
/**
 * Template for list link section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Core\Services\StringVariablesService;

	$element    = $args['element'];
	$section_id = $element['id'];
	$settings   = $element['settings'];
	$attributes = array(
		'data-builder'    => $args['builder'],
		'data-section-id' => $section_id,
	);
	?>
<div class="brandy-list-link-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper">
		<?php
		$label = $settings['label'] ?? '';
		?>
		<?php if ( is_customize_preview() || ! empty( trim( $label ) ) ) : ?>
			<div class="brandy-list-link__label<?php echo 'footer' === $args['builder'] ? ' brandy-footer-toggle-label' : ''; ?>">
				<span class="brandy-list-link__label-text"><?php echo esc_html( $label ); ?></span>
				<?php
					// if ( 'footer' === $args['builder'] ) :
					// 	echo '<span class="brandy-footer-toggle-arrow">⌃</span>';
					// endif;
				?>
			</div>
		<?php endif; ?>
		<div class="brandy-list-link__items<?php echo 'footer' === $args['builder'] ? ' brandy-footer-toggle-content' : ''; ?>">
			<?php
			foreach ( ( $settings['items'] ?? array() ) as $link_item ) :
				$item_url = $link_item['url'] ?? '#';
				$item_url = StringVariablesService::replace_variables( $item_url );
				?>
				<a class="brandy-list-link-item" <?php echo ( $settings['link_new_tab'] ?? true ) ? 'target="_blank"' : ''; ?> href="<?php echo esc_url( $item_url ); ?>"><?php echo esc_html( $link_item['label'] ?? '' ); ?></a>
			<?php endforeach; ?>
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
