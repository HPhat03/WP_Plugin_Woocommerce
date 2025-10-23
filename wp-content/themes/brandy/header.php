<?php
/**
 * The Template for displaying site header
 *
 * @package Brandy
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! headers_sent() && ! session_id() ) {
	session_start();
}

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>" />
	<?php wp_head(); ?>
</head>
<?php

	/**
	 * Body attributes
	 */
	$body_attributes = brandy_get_body_attributes();
	$button_settings = \Brandy\Core\Services\ButtonService::get_settings();
	$body_class = is_customize_preview() ? 'customize-preview' : 'front-end';
	if ( ( $button_settings['type'] ?? 'default' ) !== 'default' ) {
		$body_class .= ' custom-button-style';
	}
?>
<body <?php body_class( $body_class ); ?> <?php brandy_print_dom_attributes( $body_attributes ); ?>>
	<?php
		wp_body_open();

		brandy_header();
	?>
	<?php

		/**
		 * Site classes & attributes
		 */
		global $post;
		$site_content_classes    = apply_filters( 'brandy_site_content_classes', array( 'site-content' ) );
		$site_content_attributes = array_merge(
			array(
				'id'    => 'content',
				'class' => esc_attr( implode( ' ', $site_content_classes ) ),
			)
		);
		?>

	<?php
		/**
		 * Hook: brandy_before_site_content
		 */
		do_action( 'brandy_before_site_content' );
	?>
	<div <?php brandy_print_dom_attributes( $site_content_attributes ); ?>>
