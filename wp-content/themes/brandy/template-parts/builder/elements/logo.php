<?php
/**
 * Template for logo section
 *
 * @package Brandy\Templates\Builder\Elements
 */


	$element             = $args['element'];
	$device              = isset( $args['device'] ) ? $args['device'] : 'desktop';
	$section_id          = $element['id'];
	$settings            = $element['settings'];
	$sticky_logo_enabled = isset( $settings['sticky_logo']['enabled'] ) ? $settings['sticky_logo']['enabled'] : false;

	$attributes = array(
		'data-builder'         => $args['builder'],
		'data-section-id'      => $section_id,
		'data-has-sticky-logo' => $sticky_logo_enabled ? 'true' : 'false',
	);

	if ( ! function_exists( 'render_logo_item' ) ) {
		function render_logo_item( $logo_type, $settings, $device ) {
			$logo_settings        = 'primary' === $logo_type ? ( $settings['logo'] ?? array( 'url' => '#' ) ) : $settings['sticky_logo'];
			$mobile_logo_settings = 'primary' === $logo_type ? ( $settings['logo_mobile'] ?? array( 'url' => '#' ) ) : $settings['sticky_logo'];
			$logo_enabled         = $settings['logo_enabled_devices'] ?? array( 'desktop', 'mobile' );
			$logo_attributes      = array(
				'logo-type' => esc_attr( $logo_type ),
			);
			$logo_url             = empty( $logo_settings['url'] ) ? get_site_icon_url() : $logo_settings['url'];
			$mobile_logo_url      = empty( $mobile_logo_settings['url'] ) ? $logo_url : $mobile_logo_settings['url'];
			?>
			<div class="brandy-logo" <?php echo esc_attr( brandy_print_dom_attributes( $logo_attributes ) ); ?>>
				<?php if ( in_array( $device, $logo_enabled, true ) || is_customize_preview() ) : ?>
				<a href="<?php echo esc_url( home_url() ); ?>" class="brandy-logo-images <?php echo is_customize_preview() ? esc_attr( brandy_get_enabled_device_classes( $logo_enabled ) ) : ''; ?>">
					<?php if ( 'desktop' === $device || is_customize_preview() ) : ?>
					<img width="150" height="150" class="brandy-logo__img logo-desktop" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
					<?php endif; ?>
					<?php if ( 'desktop' !== $device || is_customize_preview() ) : ?>
					<img width="150" height="150" class="brandy-logo__img logo-mobile" src="<?php echo esc_url( $mobile_logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" data-using-desktop-source="<?php echo empty( $mobile_logo_settings['url'] ) ? 'true' : 'false'; ?>"/>
					<?php endif; ?>
				</a>
				<?php endif; ?>
				<div class="brandy-logo__content">
					<?php
					$types = array( 'title', 'tagline' );
					foreach ( $types as $type ) :
						$content_tag = 'div';
						$attributes  = array(
							'class'                => "brandy-logo__{$type} " . brandy_get_enabled_device_classes( $settings[ $type ]['enabled_devices'] ),
						);
						if ( 'title' === $type ) {
							$text               = get_bloginfo( 'name' );
							$content_tag        = 'a';
							$attributes['href'] = esc_url( home_url() );
							$attributes['data-hover-underline'] = empty( $settings[ $type ]['underline_when_hovering'] ) ? 'false' : 'true';
						} else {
							$text = get_bloginfo( 'description' );
						}
						?>
						<?php
							ob_start();
							brandy_print_dom_attributes( $attributes );
							$dom_attributes = ob_get_contents();
							ob_end_clean();
							printf(
								'<%1$s %2$s>%3$s</%1$s>',
								$content_tag,
								$dom_attributes,
								$text
							)
						?>
						<?php
					endforeach;
					?>
				</div>
			</div>
			<?php
		}
	}

	?>

<div class="brandy-element brandy-logo-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper">
		<?php render_logo_item( 'primary', $settings, $device ); ?>
		<?php if ( $sticky_logo_enabled ) : ?>
			<?php render_logo_item( 'sticky', $settings, $device ); ?>
		<?php endif; ?>
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
