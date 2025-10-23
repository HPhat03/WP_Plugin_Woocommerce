<?php

/**
 * Template for theme layout section
 *
 * @package Brandy\Templates\Builder\Elements
 */

use Brandy\Customizer\Elements\Newsletter;

$element    = $args['element'];
$section_id = $element['id'];
$settings   = $element['settings'];
$attributes = array(
	'data-builder'    => $args['builder'],
	'data-section-id' => $section_id,
);

$newsletter_title    = $settings['newsletter_title'];
$newsletter_subtitle = $settings['newsletter_subtitle'];
$placeholder         = $settings['placeholder'];
$button_text         = $settings['text_button'];
$newsletter_note     = isset( $settings['newsletter_note'] ) ? $settings['newsletter_note'] : 'We promise not send spam to you!';

$theme_layout_type = $settings['theme_layout']['type'];

$email_data = array(
	'subject'         => $settings['email_subject'] ?? Newsletter::DEFAULT_EMAIL_SUBJECT,
	'message'         => $settings['email_message'] ?? Newsletter::DEFAULT_EMAIL_MESSAGE,
	'success_message' => $settings['success_message'] ?? Newsletter::DEFAULT_SUCCESS_MESSAGE,
);

?>
<div class="brandy-newsletter-element <?php echo esc_attr( brandy_get_editable_class() ); ?>" <?php brandy_print_dom_attributes( $attributes ); ?>>
	<div class="brandy-element-wrapper layout_<?php echo esc_attr( $theme_layout_type ); ?>">
		<div class="brandy-newsletter-title"><?php echo esc_html( $newsletter_title ); ?></div>
		<p class="brandy-newsletter-subtitle"><?php echo esc_html( ( $newsletter_subtitle ) ); ?></p>
		<form class="brandy-subscribe-box" name="brandy-subscribe-form">
			<div class="brandy-subscribe-box__input">
				<span class="brandy-subscribe-box__icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" fill="none" viewBox="0 0 22 20"><path stroke="#5A6D80" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.902 6.851l-4.443 3.613c-.84.666-2.02.666-2.86 0l-4.48-3.613"></path><path stroke="#5A6D80" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.909 19C18.95 19.008 21 16.51 21 13.438V6.57C21 3.499 18.95 1 15.909 1H6.09C3.05 1 1 3.499 1 6.57v6.868C1 16.51 3.05 19.008 6.091 19h9.818z" clip-rule="evenodd"></path></svg>
				</span>
				<input type="email" name="email" autocomplete="off" placeholder="<?php echo esc_attr( $placeholder ); ?>" aria-label="<?php echo esc_attr( $placeholder ); ?>">
				<input type="hidden" name="subject" value="<?php echo esc_html( $email_data['subject'] ); ?>">
				<input type="hidden" name="message" value="<?php echo esc_html( $email_data['message'] ); ?>">
				<input type="hidden" name="success_message" value="<?php echo esc_html( $email_data['success_message'] ); ?>">
			</div>
			<button type="submit" class="brandy-subscribe-box__button brandy-subscribe-box__action-send-mail" title="Letter submit"><span class="brandy-subscribe-box__button__text"><?php echo esc_html( $button_text ); ?></span> <span class='brandy-loader' style="width:20px;height:20px;"></span></button>
		</form>
		<p class="brandy-newsletter-note"><?php echo esc_html( ( $newsletter_note ) ); ?></p>
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
