<?php
/**
 * The Template for displaying all pages
 *
 * @package Brandy
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$template_html = get_the_block_template_html();

get_header();

?>

<main <?php post_class(); ?>>

	<?php
	/**
	 * Render post
	 */
	?>
	<?php
		echo $template_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	?>

	</main>

<?php
get_footer();
