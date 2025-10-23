<?php
/**
 * Template for logo section
 *
 * @package Brandy\Templates\Builder\Elements
 */

 defined( 'ABSPATH' ) || exit;

use Brandy\Customizer\Elements\BaseSearch;

	$element         = $args['element'];
	$section_id      = $element['id'];
	$settings        = $element['settings'];
	$attributes      = array(
		'data-builder'    => $args['builder'],
		'data-section-id' => $section_id,
	);
	$search_type     = $settings['type'];
	$search_icon     = BaseSearch::get_icon( $settings['icon'] );
	$icon_position   = $settings['icon_position'];
	$placeholder     = $settings['placeholder'];
	$search_criteria = is_array( $settings['search_criteria'] ) ? 'product' : $settings['search_criteria'];

	$backdrop_type    = $settings['live_results']['type'];
	$has_live_results = $settings['live_results']['enabled'];

	$has_image     = $settings['live_results']['show_image'];
	$has_price     = $settings['live_results']['show_product_price'];
	$has_view_more = $settings['live_results']['can_view_more'];

	if ( ! function_exists( 'render_live_result_content' ) ) {
		function render_live_result_content() { ?>
			<div class="brandy-live-result__content">
				<?php echo __( 'Please type and enter to search', 'brandy' ); ?>
			</div>
			<?php
		}
	}
	?>
<div class="brandy-search-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
<?php
$attrs = array();
if ( $has_live_results ) {
	$attrs[] = 'has-live-results';
	if ( $has_image ) {
		$attrs[] = 'has-image';
	}
	if ( $has_price ) {
		$attrs[] = 'has-price';
	}
	if ( $has_view_more ) {
		$attrs[] = 'has-view-more';
	}
}

$show_suggestions = $settings['live_results']['show_suggestions'];

$individual_live_result_types = array( 'type_1', 'type_2', 'type_3', 'type_6' );

$list_view_types = array( 'type_1', 'type_4', 'type_5' );

?>
	<div class="brandy-element-wrapper" backdrop-type=<?php echo esc_attr( $backdrop_type ); ?> <?php echo esc_attr( implode( ' ', $attrs ) ); ?> icon-position=<?php echo esc_attr( $icon_position ); ?>>
		<?php if ( $has_live_results ) : ?>
			<div class="brandy-live-result-backdrop"></div>
			<?php if ( in_array( $backdrop_type, $individual_live_result_types, true ) ) : ?>
				<div class="brandy-live-result" data-layout="<?php echo in_array( $backdrop_type, $list_view_types, true ) ? 'list' : 'grid'; ?>" <?php echo ! empty( $search_criteria ) ? esc_attr( "data-result-type=$search_criteria" ) : ''; ?>>
					<div class="brandy-live-result__header">
						<div>
							<form onsubmit="return false;" class="brandy-search-box" name="brandy-search-form" type="<?php echo esc_attr( $search_type ); ?>" icon-position=<?php echo esc_attr( $icon_position ); ?> <?php echo ! empty( $search_criteria ) ? esc_attr( "search-criteria=$search_criteria" ) : ''; ?> <?php echo esc_attr( $has_view_more ? 'has-view-more' : '' ); ?>>
								<button type="submit" class="brandy-search-box__icon" title="Search button">
									<?php brandy_render_icon( $search_icon ); ?>
								</button>
								<input type="text" class="brandy-search-box__input" name="search_value" autocomplete="off" placeholder="<?php echo esc_attr( $placeholder ); ?>" aria-label="<?php echo esc_attr( $placeholder ); ?>" role="searchbox" aria-description="search results will appear below"/>
							</form>
							<div class="brandy-live-result__close">
								<?php
									ob_start();
								?>
									<svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_4112_69147)">
										<path d="M11.7465 11.0349C11.9074 11.1958 11.9979 11.4141 11.9979 11.6417C11.9979 11.8694 11.9074 12.0877 11.7465 12.2486C11.5855 12.4096 11.3672 12.5 11.1396 12.5C10.912 12.5 10.6937 12.4096 10.5327 12.2486L5.99964 7.71412L1.46515 12.2472C1.30419 12.4081 1.08589 12.4986 0.858264 12.4986C0.630638 12.4986 0.412335 12.4081 0.25138 12.2472C0.0904241 12.0862 2.39843e-09 11.8679 0 11.6403C-2.39843e-09 11.4127 0.0904241 11.1944 0.25138 11.0334L4.78587 6.50036L0.252807 1.96586C0.0918518 1.80491 0.00142799 1.5866 0.001428 1.35898C0.001428 1.13135 0.0918518 0.913049 0.252807 0.752094C0.413763 0.591138 0.632066 0.500714 0.859692 0.500714C1.08732 0.500714 1.30562 0.591138 1.46658 0.752094L5.99964 5.28659L10.5341 0.751379C10.6951 0.590424 10.9134 0.5 11.141 0.5C11.3686 0.5 11.5869 0.590424 11.7479 0.751379C11.9089 0.912335 11.9993 1.13064 11.9993 1.35826C11.9993 1.58589 11.9089 1.80419 11.7479 1.96515L7.21341 6.50036L11.7465 11.0349Z" fill="#A1ABB7"/>
									</g>
								</svg>
									<?php
									$close_icon = ob_get_contents();
									ob_end_clean();
									brandy_render_icon( $close_icon );
									?>
							</div>
						</div>
						<?php
						if ( $show_suggestions ) {
							$suggestions = $settings['live_results']['suggestions'];
							?>
							<div class="brandy-live-result__suggestions">
								<span class="brandy-live-result__suggestions__text"><?php esc_html_e( 'Search trend:', 'brandy' ); ?></span>
							<?php foreach ( $suggestions as $suggestion ) { ?>
								<span class="brandy-live-result__suggestions__item" data-value="<?php echo esc_attr( $suggestion ); ?>"><?php echo esc_html( $suggestion ); ?></span>
							<?php } ?>
							</div>
						<?php } ?>
					</div>
					<?php render_live_result_content(); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<form onsubmit="return false;" class="brandy-search-box" name="brandy-search-form" type="<?php echo esc_attr( $search_type ); ?>" icon-position=<?php echo esc_attr( $icon_position ); ?> <?php echo ! empty( $search_criteria ) ? esc_attr( "search-criteria=$search_criteria" ) : ''; ?> <?php echo esc_attr( $has_view_more ? 'has-view-more' : '' ); ?>>
			<button type="submit" class="brandy-search-box__icon trigger-tooltip trigger-icon" title="Search button">
				<?php brandy_render_icon( $search_icon ); ?>
				<span class="brandy-search-box__icon-tooltip is-tooltip"><?php esc_html_e( 'Search', 'brandy' ); ?></span>
			</button>
			<?php if ( $search_type !== 'icon' ) : ?>
				<input type="text" class="brandy-search-box__input" name="search_value" autocomplete="off" placeholder="<?php echo esc_attr( $placeholder ); ?>" aria-label="<?php echo esc_attr( $placeholder ); ?>" role="searchbox" aria-description="search results will appear below"/>
			<?php endif; ?>
		</form>
		<?php if ( $has_live_results && ! in_array( $backdrop_type, $individual_live_result_types, true ) ) : ?>
		<div class="brandy-live-result" data-layout="<?php echo in_array( $backdrop_type, $list_view_types, true ) ? 'list' : 'grid'; ?>" <?php echo ! empty( $search_criteria ) ? esc_attr( "data-result-type=$search_criteria" ) : ''; ?>>
			<?php render_live_result_content(); ?>
		</div>
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
