<?php
/**
 * Template for language switcher section
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
	$languages  = $settings['languages'];
	$flag_name  = $settings['flag_name'];

	$current_language_slug = Helpers::get_current_language( $languages[0]['id'] ?? 'en' );

	if ( ! function_exists( 'language_render_item' ) ) {
		function language_render_item( $language, $settings ) {
			if ( empty( $language ) ) {
				return;
			}
			$flag_icon_style = $settings['flag_icon_style'];
			$show_flag       = $settings['show_flag'] ?? false;
			$show_name       = $settings['flag_name']['display'] ?? true;
			$flag_name_type  = $settings['flag_name']['name_type'] ?? 'country_language';
			if ( is_customize_preview() || ( $settings['show_flag'] ?? false ) ) :
				?>
				<span class="brandy-lang-flag <?php echo $show_flag ? '' : 'hidden'; ?>" icon-style="<?php echo esc_attr( $flag_icon_style ); ?>">
					<span class="flag-wrapper">
				<?php
				$flag = BRANDY_TEMPLATE_DIR . '/template-parts/flags/' . $language['flag'] . '.svg';
				if ( file_exists( $flag ) ) {
					require $flag;
				}
				?>
				</span>
			</span>
			<?php endif; ?>
			<?php if ( is_customize_preview() || ( $settings['flag_name']['display'] ?? true ) ) : ?>
			<span class="brandy-lang-name <?php echo $show_name ? '' : 'hidden'; ?>"><?php echo esc_html( 'country_language' === $flag_name_type ? $language['language_name'] : $language['country_code'] ); ?></span>
			<?php endif; ?>
				<?php
		}
	}

	$show_type = $settings['show_type'];

	?>
<div class="brandy-lang-switcher-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper relative" show-type=<?php echo esc_attr( $show_type ); ?>>
		<?php if ( 'dropdown' === $show_type ) : ?> 
		<div class="brandy-lang-switcher__placeholder">
			<?php
			$current_language = array_filter(
				$languages,
				function( $language ) use ( $current_language_slug ) {
					return $language['id'] === $current_language_slug;
				}
			);
			language_render_item( current( $current_language ) ?? null, $settings );
			?>
			
			<span class="brandy-lang-arrow">⌃</span>
		</div>
		<?php endif; ?>
		<div class="brandy-lang-options" type=<?php echo esc_attr( $show_type ); ?>>
			<?php
			foreach ( $languages as $language ) :
				$lang_url = Helpers::get_language_url( $language['id'] );
				?>
				<a data-wg-notranslate="" class="brandy-lang-option <?php echo esc_attr( $current_language_slug === $language['id'] ? 'selected' : '' ); ?>" data-lang="<?php echo esc_attr( $language['id'] ); ?>" href="<?php echo esc_url( $lang_url ); ?>">
					<div class="brandy-lang-option__content">
						<?php
						language_render_item( $language, $settings );
						?>
					</div>
				</a>
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
