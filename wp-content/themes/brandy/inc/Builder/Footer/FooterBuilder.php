<?php

namespace Brandy\Builder\Footer;

use Brandy\Builder\Element\ElementBuilder;
use Brandy\Traits\SingletonTrait;
use Brandy\Utils\Helpers;

class FooterBuilder {

	use SingletonTrait;

	protected function __construct() {
		add_action( 'brandy_footer', array( $this, 'render_footer' ) );
		add_action( 'brandy_render_footer_placement', array( $this, 'render_placement' ), 10, 3 );
	}

	public function render_footer() {
		get_template_part( 'template-parts/builder/footer/footer-layout' );
	}

	public function render_placement( string $placement, $device, $row_settings ) {

		$current_template = brandy_get_footer_template();
		$columns          = $current_template['placements'][ $device ][ $placement ];
		foreach ( $columns as $col_index => $col_elements ) :
			$col_attributes = array(
				'class' => 'footer-col',
			);
			foreach ( brandy_get_devices() as $d ) {
				$d_items_direction = Helpers::get_device_value( $row_settings['column_items_direction'], $d );
				if ( isset( $d_items_direction[ 'column_' . ( $col_index + 1 ) ] ) ) {
					$col_attributes[ "data-items-direction-$d" ] = $d_items_direction[ 'column_' . ( $col_index + 1 ) ];
				}
			}
			?>
			<div <?php brandy_print_dom_attributes( $col_attributes ); ?>>
			<?php
			foreach ( $col_elements as $element_id ) {
				$element  = $current_template['elements'][ $element_id ];
				$renderer = new ElementBuilder( 'footer', $element, $device );
				$renderer->render();
			}
			?>
			</div>
			<?php
		endforeach;
	}
}
