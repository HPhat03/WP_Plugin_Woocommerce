<?php

use Brandy\Admin\PostEditor\MetaServices\HeaderTransparentMetaService;
use Brandy\Builder\Header\HeaderBuilder;
use Brandy\Utils\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	do_action( 'brandy_before_header' );
	$current_template  = brandy_get_header_template();
	$header_attributes = array(
		'class' => ! empty( $current_template['settings']['transparent']['enabled'] ) ? 'brandy-header-transparent' : ' ',
	);

	$rows = array( 'top', 'middle', 'bottom' );

	$header_transparent_meta_value = HeaderTransparentMetaService::get_value( get_the_ID() );

	if ( 'disable' === $header_transparent_meta_value ) {
		$header_attributes['class'] = '';
	}

	if ( 'enable' === $header_transparent_meta_value ) {
		$header_attributes['class'] = 'brandy-header-transparent';
	}

	?>
<header id="brandy-header" data-section-id="header" <?php brandy_print_dom_attributes( $header_attributes ); ?>>
	<?php
	foreach ( array( 'desktop', 'mobile' ) as $device ) :
		$user_device = brandy_get_user_device();
		if ( 'mobile' === $user_device && $user_device !== $device ) {
			continue;
		}
		$is_sticky                   = isset( $current_template['settings']['sticky_functionality']['enabled'] ) ? Helpers::get_device_value( $current_template['settings']['sticky_functionality']['enabled'], $device ) : false;
		$sticky_on                   = isset( $current_template['settings']['sticky_functionality']['sticky_on'] ) ? Helpers::get_device_value( $current_template['settings']['sticky_functionality']['sticky_on'], $device ) : 'middle';
		$effect                      = isset( $current_template['settings']['sticky_functionality']['sticky_effect'] ) ? Helpers::get_device_value( $current_template['settings']['sticky_functionality']['sticky_effect'], $device ) : 'default';
		$only_show_when_scrolling_up = isset( $current_template['settings']['sticky_functionality']['only_show_when_scrolling_up'] ) ? Helpers::get_device_value( $current_template['settings']['sticky_functionality']['only_show_when_scrolling_up'], $device ) : 'true';
		?>
		<div device=<?php echo esc_attr( $device ); ?> class="header-within-device">
			<?php
			if ( ! $is_sticky ) :
				foreach ( $rows as $row ) {
					HeaderBuilder::get_instance()->render_row( $row, $device );
				}
			else :
				if ( strpos( $sticky_on, 'top' ) === false ) {
					HeaderBuilder::get_instance()->render_row( 'top', $device );
					if ( strpos( $sticky_on, 'middle' ) === false ) {
						HeaderBuilder::get_instance()->render_row( 'middle', $device );
					}
				}
				?>
			<div class="sticky-headers">
				<div class="sticky-part" effect=<?php echo esc_attr( $effect ); ?> data-only-show-when-scrolling-up=<?php echo esc_attr( $only_show_when_scrolling_up ? 'true' : 'false' ); ?>>
					<?php
					foreach ( $rows as $row ) {
						if ( strpos( $sticky_on, $row ) !== false ) {
							HeaderBuilder::get_instance()->render_row( $row, $device );
						}
					}
					?>
				</div>
			</div>
				<?php
				if ( strpos( $sticky_on, 'bottom' ) === false ) {
					if ( strpos( $sticky_on, 'middle' ) === false ) {
						HeaderBuilder::get_instance()->render_row( 'middle', $device );
					}
					HeaderBuilder::get_instance()->render_row( 'bottom', $device );
				}
				?>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</header>

<?php
	do_action( 'brandy_after_header' );
