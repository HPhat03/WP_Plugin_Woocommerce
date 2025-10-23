<?php

namespace Brandy\Integrations;

use Brandy\Traits\SingletonTrait;

class YayExtraIntegration {
	use SingletonTrait;

	protected function __construct() {
		if ( ! defined( 'YAYE_VERSION' ) ) {
			return;
		}
		add_action( 'wp_head', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() {
		if ( ! wp_style_is( 'yayextra-css' ) ) {
			return;
		}
		?>
		<style>.yayextra-option-set {width: 100%;}.yayextra-option-field-name{margin-bottom: 6px;}.yayextra-time-picker {position:absolute;z-index:10;box-shadow: 0 0 10px #0000001a !important;width: fit-content;border-radius: 9px !important;}.yayextra-datetimepicker {border: none !important;width: fit-content;}.yayextra-datetimepicker table:nth-child(1){padding:.75rem .75rem 4px .75rem;}.yayextra-datetimepicker table:nth-child(2){padding:4px .75rem .75rem .75rem;}.yayextra-datetimepicker table:nth-child(2) {font-size: 0.75rem;}.yayextra-datetimepicker table:nth-child(2) td{background:#f6f6f6;transition:all ease-in-out .2s;}.yayextra-datetimepicker table:nth-child(2) td:hover {background:#dcdcdc}.yayextra-datetimepicker table:first-child td {cursor: auto;}.yayextra-datetimepicker table.tt input {background-color: #ffffff !important;color: var(--wp--preset--color--brandy-primary-text) !important;width: 100% !important;border-width: 1px !important;border-color: var(--input-border-color) !important;border-style: solid !important;border-radius: 4px !important;outline-width: 1px !important;outline-color: transparent !important;outline-style: solid !important;padding: 5px 10px !important;box-shadow: none !important;transition-property: outline, border !important;transition-duration: var(--theme-input-transition-duration) !important;transition-timing-function: ease-in-out !important;height: unset !important;width: unset !important;}.yayextra-datetimepicker table.tt input:focus {outline-color: var(--input-focus-border-color) !important;border-color: transparent !important;outline-width: calc(1px + 1px) !important;outline-style: solid !important;color: var(--wp--preset--color--brandy-primary-text) !important;background-color: #ffffff !important;box-shadow: none !important;}[data-option-field-type="radio"] > *:not(.yayextra-option-field-name),[data-option-field-type="checkbox"] > *:not(.yayextra-option-field-name) {display: flex;align-items: center;margin-bottom: 5px;}[data-option-field-type="radio"] > *:not(.yayextra-option-field-name):last-child,[data-option-field-type="checkbox"] > *:not(.yayextra-option-field-name):last-child {margin-bottom: 0;}[data-option-field-type="radio"] > *:not(.yayextra-option-field-name) > span,[data-option-field-type="checkbox"] > *:not(.yayextra-option-field-name) > span {display: flex;align-items: center;}
		</style>
		<?php
	}
}
