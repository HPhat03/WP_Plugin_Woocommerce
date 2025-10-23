<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	do_action( 'brandy_before_footer' );
	$current_template = brandy_get_footer_template();
	$rows             = array( 'top', 'middle', 'bottom' );
?>
<footer id="brandy-footer" data-section-id="footer">
	<?php
	foreach ( array( 'desktop', 'mobile' ) as $device ) :
		$user_device = brandy_get_user_device();
		if ( 'mobile' === $user_device && $user_device !== $device ) {
			continue;
		}
		?>
		<div device="<?php echo esc_attr( $device ); ?>">
		<?php
		foreach ( $rows as $row ) {
			get_template_part(
				'template-parts/builder/footer/footer-row-layout',
				'',
				array(
					'row'    => $row,
					'device' => $device,
				)
			);
		}
		?>
		</div>
	<?php endforeach; ?>
</footer>

<?php
	do_action( 'brandy_after_footer' );
