<?php

namespace Brandy\Core\Services;

use Brandy\Traits\SingletonTrait;
use Brandy\Utils\Helpers;

/**
 * Typography Service
 */
class TypographyService {
	use SingletonTrait;

	/**
	 * Returns default typography
	 *
	 * @param array $args Value to parse
	 *
	 * @return array
	 */
	public static function get_default_typography_value( $args = array() ) {
		return $args;
	}

	public static function get_value( $args = array() ) {
		$default_typography = array(
			'font_style'     => array(
				'desktop' => array(
					'weight' => 400,
					'italic' => false,
				),
				'tablet'  => null,
				'mobile'  => null,
			),
			'font_size'      => array(
				'desktop' => array(
					'unit'  => 'px',
					'value' => '',
					'min'   => 1,
					'max'   => 30,
				),
				'tablet'  => null,
				'mobile'  => null,
			),
			'line_height'    => array(
				'desktop' => array(
					'unit'  => 'px',
					'value' => '',
					'min'   => 0,
					'max'   => 100,
				),
				'tablet'  => null,
				'mobile'  => null,
			),
			'letter_spacing' => array(
				'desktop' => array(
					'unit'  => 'px',
					'value' => '',
					'min'   => 0,
					'max'   => 10,
				),
				'tablet'  => null,
				'mobile'  => null,
			),
			'transform'      => array(
				'desktop' => 'none',
				'tablet'  => null,
				'mobile'  => null,
			),
			'decoration'     => array(
				'desktop' => 'auto',
				'tablet'  => null,
				'mobile'  => null,
			),
		);

		return Helpers::recursive_wp_parse_args( $args, $default_typography );
	}
}
