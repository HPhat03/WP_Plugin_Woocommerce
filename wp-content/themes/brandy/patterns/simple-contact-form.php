<?php
/**
 * Title: Brandy Simple Contact Form
 * Slug: brandy/simple-contact-form
 * Categories: brandy
 * Viewport Width: 1500
 */
?>

<!-- wp:brandy/form {"action":"custom","metadata":{"categories":["brandy"],"patternName":"brandy/simple-contact-form","name":"Brandy simple contact form"},"align":"wide"} -->
<div class="wp-block-brandy-form alignwide"><!-- wp:group {"responsiveLayout":{"enabled":true,"tablet":{"columnType":"manual","value":"1"},"mobile":{"columnType":"manual","value":"1"}},"style":{"spacing":{"blockGap":"30px"}},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":null}} -->
<div class="wp-block-group"><!-- wp:brandy/form-input {"name":"full_name","isRequired":false,"label":"Full name:","id":"full_name","autocomplete":false} -->
<div class="wp-block-brandy-form-input"><label class="wp-block-brandy-form-label" for="full_name">Full name: </label><input class="wp-block-brandy-form-field" id="full_name" name="full_name" autocomplete="off" type="text"/></div>
<!-- /wp:brandy/form-input -->

<!-- wp:brandy/form-email {"name":"email_address","label":"Email Address:","id":"email_address","autocomplete":false} -->
<div class="wp-block-brandy-form-email"><label class="wp-block-brandy-form-label" for="email_address">Email Address:</label><input class="wp-block-brandy-form-field" type="text" id="email_address" name="email_address" autocomplete="off" pattern="/^[a-zA-Z0-9.!#$%&amp;’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$/"/></div>
<!-- /wp:brandy/form-email -->

<!-- wp:brandy/form-phone {"name":"phone_number","label":"Phone Number:","id":"phone_number","autocomplete":false} -->
<div class="wp-block-brandy-form-phone"><label class="wp-block-brandy-form-label" for="phone_number">Phone Number:</label><input class="wp-block-brandy-form-field" type="tel" id="phone_number" name="phone_number" autocomplete="off" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"/></div>
<!-- /wp:brandy/form-phone -->

<!-- wp:brandy/form-input {"name":"subject","isRequired":false,"label":"Subject:","id":"subject","autocomplete":false} -->
<div class="wp-block-brandy-form-input"><label class="wp-block-brandy-form-label" for="subject">Subject: </label><input class="wp-block-brandy-form-field" id="subject" name="subject" autocomplete="off" type="text"/></div>
<!-- /wp:brandy/form-input --></div>
<!-- /wp:group -->

<!-- wp:brandy/form-input {"name":"message","isRequired":false,"label":"Message:","id":"message","autocomplete":false,"type":"textarea"} -->
<div class="wp-block-brandy-form-input"><label class="wp-block-brandy-form-label" for="message">Message: </label><textarea class="wp-block-brandy-form-field" id="message" name="message" autocomplete="off" rows="5"></textarea></div>
<!-- /wp:brandy/form-input -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--30)"><!-- wp:brandy/form-submit {"width":"150px","style":{"spacing":{"padding":{"top":"0.89rem","bottom":"0.89rem"}},"typography":{"fontSize":"18px"}}} -->
<button class="wp-element-button has-text-align-center" class="wp-block-brandy-form-submit wp-element-button has-text-align-center" style="padding-top:0.89rem;padding-bottom:0.89rem;font-size:18px;width:150px">Submit</button>
<!-- /wp:brandy/form-submit --></div>
<!-- /wp:group --></div>
<!-- /wp:brandy/form -->