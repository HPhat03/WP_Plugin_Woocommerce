<?php

namespace Brandy\Utils;

use Brandy\Core\Services\TypographyService;
use Brandy\DynamicCss;

class StylesDataHelpers {

	/**
	 * Check is valid spacing data
	 *
	 * Data valid should includes these keys array( 'unit', 'top', 'right', 'bottom', 'left' ).
	 *
	 * @param           $data   Given data to check.
	 *
	 * @return bool
	 */
	public static function is_spacing_data( $data ) {
		return is_array( $data ) && ! array_diff_key( array_flip( array( 'unit', 'top', 'right', 'bottom', 'left' ) ), $data );
	}

	/**
	 * Check is valid dimension data
	 *
	 * Data valid should includes these keys array( 'unit', 'value' ).
	 *
	 * @param           $data   Given data to check.
	 *
	 * @return bool
	 */
	public static function is_dimension_data( $data ) {
		return is_array( $data ) && ! array_diff_key( array_flip( array( 'unit', 'value' ) ), $data );
	}

	/**
	 * Check is valid box shadow data
	 *
	 * Data valid should includes these keys array( 'enabled', 'type', 'custom_value' ).
	 *
	 * @param           $data   Given data to check.
	 *
	 * @return bool
	 */
	public static function is_box_shadow_data( $data ) {
		return is_array( $data ) && ! array_diff_key( array_flip( array( 'enabled', 'type', 'custom_value' ) ), $data );
	}

	/**
	 * Returns padding css for given spacing data
	 *
	 * @param array $spacing Array describe spacing data array(
	 * @type    string  $unit
	 * @type    number  $top
	 * @type    number  $right
	 * @type    number  $bottom
	 * @type    number  $left
	 * )
	 *
	 * @return string Padding css
	 */
	public static function get_spacing_css( $spacing ) {
		if ( ! self::is_spacing_data( $spacing ) ) {
			return '';
		}
		$unit   = $spacing['unit'];
		$top    = $spacing['top'];
		$right  = $spacing['right'];
		$bottom = $spacing['bottom'];
		$left   = $spacing['left'];

		if ( 'wp' === $unit ) {
			if ( $top === $right && $right === $bottom && $bottom === $left ) {
				return "$top";
			}
			return "$top $right $bottom $left";
		}

		if ( $top === $right && $right === $bottom && $bottom === $left ) {
			return "$top$unit";
		}
		return "$top$unit $right$unit $bottom$unit $left$unit";
	}

	/**
	 * Returns dimension css for given dimension data
	 *
	 * @param array $spacing Array describe spacing data array(
	 * @type    string  $unit
	 * @type    number  $value
	 * )
	 *
	 * @return string Dimension css
	 */
	public static function get_dimension_css( $dimension ) {
		if ( ! self::is_dimension_data( $dimension ) ) {
			return '';
		}
		return $dimension['value'] . $dimension['unit'];
	}

	/**
	 * Check given data whether is responsive
	 */
	public static function is_responsive_data( $data ) {
		return isset( $data['desktop'] ) || isset( $data['tablet'] ) || isset( $data['mobile'] );
	}

	public static function get_default_box_shadow_css() {
		return '0px 4px 16px 0px rgba(0, 0, 0, 0.06)';
	}
	public static function get_small_box_shadow_css() {
		return '0px 4px 16px 0px rgba(0, 0, 0, 0.05)';
	}
	public static function get_medium_box_shadow_css() {
		return '0px 6px 20px 0px rgba(0, 0, 0, 0.10)';
	}
	public static function get_large_box_shadow_css() {
		return '0px 10px 26px 0px rgba(0, 0, 0, 0.16)';
	}

	/**
	 * Parse box shadow settings into proper variable
	 */
	public static function get_box_shadow_css( $data ) {
		if ( ! self::is_box_shadow_data( $data ) ) {
			return '';
		}
		if ( empty( $data['enabled'] ) ) {
			return '0';
		}
		if ( 'default' === $data['type'] ) {
			return self::get_default_box_shadow_css();
		}
		if ( 'small' === $data['type'] ) {
			return self::get_small_box_shadow_css();
		}
		if ( 'medium' === $data['type'] ) {
			return self::get_medium_box_shadow_css();
		}
		if ( 'large' === $data['type'] ) {
			return self::get_large_box_shadow_css();
		}
		return $data['custom_value']['x'] . 'px ' . $data['custom_value']['y'] . 'px ' . $data['custom_value']['blur'] . 'px ' . $data['custom_value']['spread'] . 'px ' . $data['custom_value']['color'];
	}

	public static function get_typography_css( $data, $prefix, $selector = 'body' ) {

		$variables = self::get_typography_css_variables( $data, $prefix );

		$device_css = array(
			'desktop' => '',
			'tablet'  => '',
			'mobile'  => '',
		);

		foreach ( $variables as  $device => $data ) {
			$css = implode( ';', $data );
			if ( ! empty( $css ) ) {
				$device_css[ $device ] .= $selector . '{' . $css . '}';
			}
		}

		$result = '';

		foreach ( $device_css as $device => $css ) {
			if ( ! in_array( $device, brandy_get_devices(), true ) ) {
				continue;
			}
			if ( 'tablet' === $device ) {
				$css = DynamicCss::wrap_tablet_responsive( $css );
			}
			if ( 'mobile' === $device ) {
				$css = DynamicCss::wrap_mobile_responsive( $css );
			}
			$result .= $css;
		}

		return $result;
	}

	/**
	 * Generates CSS properties for different directions based on the given name and spacing values.
	 *
	 * @param string $name The name to be used as a prefix for the CSS properties.
	 * @param array $spacing An associative array containing spacing values for each direction (top, right, bottom, left).
	 * @return array An associative array containing CSS properties for each direction.
	 */
	public static function get_directions_spacing_css_variables( $name, $spacing ) {
		if ( ! self::is_spacing_data( $spacing ) ) {
			return array();
		}
		$directions = array( 'top', 'right', 'bottom', 'left' );
		$result     = array();
		foreach ( $directions as $direction ) {
			if ( 'wp' === $spacing['unit'] ) {
				$result[] = "$name-$direction:" . $spacing[ $direction ];
			} else {
				$result[] = "$name-$direction:" . $spacing[ $direction ] . $spacing['unit'];
			}
		}
		return $result;
	}

	/**
	 * Generates CSS properties for different directions based on the given name and spacing values.
	 *
	 * @param string $name The name to be used as a prefix for the CSS properties.
	 * @param array $spacing An associative array containing spacing values for each direction (top, right, bottom, left).
	 * @return array An associative array containing CSS properties for each direction.
	 */
	public static function get_directions_css_variables( $name, $css_value ) {
		$directions = array( 'top', 'right', 'bottom', 'left' );
		$result     = array();
		foreach ( $directions as $direction ) {
			$result[] = "$name-$direction:$css_value";
		}
		return $result;
	}

	public static function get_css_variable( $name, $value ) {
		if ( empty( $value ) ) {
			return '';
		}
		// if ( is_rtl() ) {
		// 	if ( 'right' === $value ) {
		// 		$value = 'left';
		// 	}
		// 	if ( 'left' === $value ) {
		// 		$value = 'right';
		// 	}
		// }
		if ( is_array( $value ) ) {
			return '';
		}
		if ( is_array( $name ) ) {
			return '';
		}

		return "$name:$value";
	}

	public static function get_spacing_css_variable( $name, $data ) {
		return self::get_css_variable( $name, self::get_spacing_css( $data ) );
	}

	public static function get_dimension_css_variable( $name, $data ) {
		return self::get_css_variable( $name, self::get_dimension_css( $data ) );
	}

	public static function get_box_shadow_css_variable( $name, $data ) {
		return self::get_css_variable( $name, self::get_box_shadow_css( $data ) );
	}

	public static function get_typography_css_variables( $data, $selector = '' ) {

		$result = array(
			'desktop' => array(),
			'tablet'  => array(),
			'mobile'  => array(),
		);

		if ( empty( $data ) ) {
			$data = array();
		}

		foreach ( $data as $typo_type => $typo_value ) {
			if ( is_null( $typo_value ) ) {
				continue;
			}
			foreach ( $typo_value as $device => $variable_value ) {
				if ( ! in_array( $device, brandy_get_devices(), true ) ) {
					continue;
				}
				$variable_value = Helpers::get_device_value( $typo_value, $device );
				if ( is_null( $variable_value ) ) {
					continue;
				}
				if ( 'font_style' === $typo_type ) {
					if ( ! empty( $selector ) ) {

						if ( ! isset( $result[ $device ][ $selector ] ) ) {
							$result[ $device ][ $selector ] = array();
						}

						$result[ $device ][ $selector ][] = self::get_css_variable( 'font-weight', $variable_value['weight'] );
						$result[ $device ][ $selector ][] = self::get_css_variable( 'font-style', $variable_value['italic'] ? 'italic' : 'normal' );
					} else {
						$result[ $device ][] = self::get_css_variable( 'font-weight', $variable_value['weight'] );
						$result[ $device ][] = self::get_css_variable( 'font-style', $variable_value['italic'] ? 'italic' : 'normal' );
					}
					continue;
				}
				if ( in_array( $typo_type, array( 'font_size', 'line_height', 'letter_spacing' ), true ) ) {
					$dimension_css = self::get_dimension_css( $variable_value );
					if ( empty( $variable_value['value'] ) ) {
						$dimension_css = 'inherit';
					}
					if ( empty( $dimension_css ) ) {
						$dimension_css = 'inherit';
					}
					if ( ! empty( $selector ) ) {

						if ( ! isset( $result[ $device ][ $selector ] ) ) {
							$result[ $device ][ $selector ] = array();
						}

						$result[ $device ][ $selector ][] = self::get_css_variable( str_replace( '_', '-', $typo_type ), $dimension_css );
					} else {
						$result[ $device ][] = self::get_css_variable( str_replace( '_', '-', $typo_type ), $dimension_css );
					}
					continue;
				}

				if ( 'transform' === $typo_type ) {
					$typo_type = 'text-transform';
				}
				if ( 'decoration' === $typo_type ) {
					$typo_type = 'text-decoration';
				}

				if ( ! empty( $selector ) ) {

					if ( ! isset( $result[ $device ][ $selector ] ) ) {
						$result[ $device ][ $selector ] = array();
					}

					$result[ $device ][ $selector ][] = self::get_css_variable( str_replace( '_', '-', $typo_type ), $variable_value );
				} else {
					$result[ $device ][] = self::get_css_variable( str_replace( '_', '-', $typo_type ), $variable_value );
				}
			}
		}

		return $result;

	}
}
