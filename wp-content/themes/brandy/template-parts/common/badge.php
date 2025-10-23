<?php

$number = isset( $args['number'] ) ? $args['number'] : '';

$attrs = isset( $args['attrs'] ) ? $args['attrs'] : '';

$class = isset( $args['class'] ) ? $args['class'] : '';

if ( empty( $number ) && ! is_numeric( $number ) && ! is_string( $number ) ) {
	return;
}

if ( ! is_string( $attrs ) ) {
	$attrs = '';
}

?>

<div class="brandy-count-badge brandy-element-count-badge <?php echo esc_attr( $class ); ?>" <?php echo esc_attr( $attrs ); ?>><?php echo ! empty( $number ) ? esc_html( $number ) : ''; ?></div>
