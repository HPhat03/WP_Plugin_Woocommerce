<?php

namespace Brandy\Builder\Header;

use Brandy\Builder\Element\ElementBuilder;
use Brandy\Builder\RowBuilder;
use Brandy\Traits\SingletonTrait;

class HeaderBuilder {

	use SingletonTrait;

	protected function __construct() {
		$this->load_dependencies();
		add_action( 'brandy_header', array( $this, 'render_header' ) );
		add_action( 'brandy_render_header_placement', array( $this, 'render_placement' ), 10, 2 );
	}

	private function load_dependencies() {
		ToggleOffCanvasBuilder::get_instance();
	}

	public function render_header() {
		get_template_part( 'template-parts/builder/header/header-layout' );
	}

	public function render_placement( string $row, $device ) {
		$current_template = brandy_get_header_template();
		$columns          = $current_template['placements'][ 'tablet' === $device ? 'mobile' : $device ][ $row ];
		foreach ( $columns as $col_index => $col_elements ) {
			if ( empty( $col_elements ) ) {
				continue;
			}
			$is_center      = count( $columns ) % 2 !== 0 && intval( count( $columns ) / 2 ) == $col_index;
			$col_attributes = array(
				'class' => 'header-col col-' . ( $col_index + 1 ),
			);

			if ( $is_center ) {
				$col_attributes['class'] .= ' is-center justify-center';
			}
			if ( $col_index > ( count( $columns ) / 2 ) ) {
				$col_attributes['class'] .= ' justify-end';
			}

			?>
			<div <?php brandy_print_dom_attributes( $col_attributes ); ?>>
				<?php
				foreach ( $col_elements as $element_id ) {
					$element  = $current_template['elements'][ $element_id ];
					$renderer = new ElementBuilder( 'header', $element, $device );
					$renderer->render();
				}
				?>
			</div>
			<?php
		}
	}

	public function render_row( $row = 'top', $device = 'desktop' ) {
		( new RowBuilder( 'header', $row, $device ) )->render();
	}
}
