<?php

$icon = isset( $args['icon'] ) ? $args['icon'] : '';

$attrs = isset( $args['attrs'] ) ? $args['attrs'] : array();

if ( ! is_array( $attrs ) ) {
	$attrs = array();
}

if ( isset( $attrs['class'] ) ) {
	$attrs['class'] = 'brandy-theme-icon ' . $attrs['class'];
} else {
	$attrs['class'] = 'brandy-theme-icon';
}

?>

<div <?php brandy_print_dom_attributes( $attrs ); ?> ><?php echo $icon; //phpcs:ignore ?></div>
