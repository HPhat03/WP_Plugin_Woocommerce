<?php
/**
 * Helpers
 */
namespace Brandy\Utils;

class Helpers {

	/**
	 * Update Object nested value with given path.
	 *
	 * @param array     $object Object to change value.
	 * @param array     $path   Given path.
	 * @param           $value  Value to set.
	 */
	public static function set_nested_value( &$object, $path, $value ) {
		$nested_data = &$object;
		$path_length = count( $path );
		while ( 1 < $path_length ) {
			$attribute_key = array_shift( $path );
			if ( ! isset( $nested_data[ $attribute_key ] ) ) {
				$nested_data[ $attribute_key ] = array();
			}
			$nested_data = &$nested_data[ $attribute_key ];
			$path_length = count( $path );
		}
		$attribute_key                 = array_shift( $path );
		$nested_data[ $attribute_key ] = $value;
	}

	/**
	 * Get Object nested value with given path.
	 *
	 * @param array     $object Object to change value.
	 * @param array     $path   Given path.
	 */
	public static function get_nested_value( &$object, $path, $default_value = null ) {
		$nested_data = &$object;
		$path_length = count( $path );
		while ( 1 < $path_length ) {
			$attribute_key = array_shift( $path );
			if ( ! isset( $nested_data[ $attribute_key ] ) ) {
				$nested_data[ $attribute_key ] = array();
			}
			$nested_data = &$nested_data[ $attribute_key ];
			$path_length = count( $path );
		}
		$attribute_key = array_shift( $path );
		return isset( $nested_data[ $attribute_key ] ) ? $nested_data[ $attribute_key ] : $default_value;
	}

	/**
	 * Make wp_parse_args function applying for nested
	 *
	 * @param array $args_1
	 * @param array $args_2
	 */
	public static function recursive_wp_parse_args( &$args_1, $args_2 ) {
		$args_1 = (array) $args_1;
		$args_2 = (array) $args_2;
		$result = $args_2;
		foreach ( $args_1 as $key => &$value ) {
			if ( isset( $result[$key] ) && is_array( $result[$key] ) && ( count( $result[$key] ) === 0 || is_numeric( array_keys( $result[$key] )[0] )) ) {
				$result[ $key ] = $args_1[ $key ];
				continue;	
			}
			if ( is_array( $value ) && isset( $result[ $key ] ) ) {
				$result[ $key ] = self::recursive_wp_parse_args( $value, $result[ $key ] );
			} else {
				$result[ $key ] = $value;
			}
		}
		return $result;
	}

	/**
	 * Get value for given device.
	 *
	 * If given data cannot be responsived, do not process. Returns itself.
	 *
	 * @param           $data       Given data. This can be anything.
	 * @param string    $device     Given device.
	 */
	public static function get_device_value( $data, $device = 'desktop' ) {
		if ( StylesDataHelpers::is_responsive_data( $data ) ) {

			if ( 'mobile' === $device ) {
				return $data['mobile'] ?? $data['tablet'] ?? $data['desktop'];
			}

			return $data[ $device ] ?? $data['desktop'];

		}
		return $data;
	}

	public static function colorToRGB( $color ) {
		if ( preg_match( '/^#([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$/', $color ) ) {
			// HEX color format
			return self::hexToRGB( $color );
		} elseif ( preg_match( '/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/', $color, $matches ) ) {
			// RGB color format
			return array(
				'r' => (int) $matches[1],
				'g' => (int) $matches[2],
				'b' => (int) $matches[3],
			);
		} elseif ( preg_match( '/^hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)$/', $color, $matches ) ) {
			// HSL color format
			return self::hslToRGB( (int) $matches[1], (int) $matches[2], (int) $matches[3] );
		} else {
			return null;
		}
	}

	// Convert HEX color to RGB
	public static function hexToRGB( $hex ) {
		$hex = ltrim( $hex, '#' );

		if ( strlen( $hex ) == 3 ) {
			// If shorthand HEX (#FFF), expand to #FFFFFF
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}

		return array(
			'r' => hexdec( substr( $hex, 0, 2 ) ),
			'g' => hexdec( substr( $hex, 2, 2 ) ),
			'b' => hexdec( substr( $hex, 4, 2 ) ),
		);
	}

	// Convert HSL to RGB
	public static function hslToRGB( $h, $s, $l ) {
		$s /= 100;
		$l /= 100;

		$c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
		$x = $c * ( 1 - abs( fmod( $h / 60, 2 ) - 1 ) );
		$m = $l - $c / 2;

		if ( $h >= 0 && $h < 60 ) {
			$rgb = array( $c, $x, 0 );
		} elseif ( $h >= 60 && $h < 120 ) {
			$rgb = array( $x, $c, 0 );
		} elseif ( $h >= 120 && $h < 180 ) {
			$rgb = array( 0, $c, $x );
		} elseif ( $h >= 180 && $h < 240 ) {
			$rgb = array( 0, $x, $c );
		} elseif ( $h >= 240 && $h < 300 ) {
			$rgb = array( $x, 0, $c );
		} else {
			$rgb = array( $c, 0, $x );
		}

		return array(
			'r' => round( ( $rgb[0] + $m ) * 255 ),
			'g' => round( ( $rgb[1] + $m ) * 255 ),
			'b' => round( ( $rgb[2] + $m ) * 255 ),
		);
	}

	public static function getLuminance( $rgb ) {
		$r = $rgb['r'] / 255;
		$g = $rgb['g'] / 255;
		$b = $rgb['b'] / 255;

		// Apply gamma correction
		$r = ( $r <= 0.03928 ) ? $r / 12.92 : pow( ( $r + 0.055 ) / 1.055, 2.4 );
		$g = ( $g <= 0.03928 ) ? $g / 12.92 : pow( ( $g + 0.055 ) / 1.055, 2.4 );
		$b = ( $b <= 0.03928 ) ? $b / 12.92 : pow( ( $b + 0.055 ) / 1.055, 2.4 );

		// Calculate luminance
		return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
	}

	// Adjust RGB color by a percentage (positive for lightening, negative for darkening)
	public static function generate_hover_color( $color, $percent = -0.15 ) {

		if ( false !== strpos( $color, 'var:preset|color|' ) ) {
			$preset_color_slug = str_replace( 'var:preset|color|', '', $color );
			$global_settings   = wp_get_global_settings();
			foreach ( ( $global_settings['color']['palette']['default'] ?? array() ) as $preset_data ) {
				if ( $preset_data['slug'] === $preset_color_slug ) {
					$color = $preset_data['color'];
				}
			}
			foreach ( ( $global_settings['color']['palette']['theme'] ?? array() ) as $preset_data ) {
				if ( $preset_data['slug'] === $preset_color_slug ) {
					$color = $preset_data['color'];
				}
			}
		}

		$rgb = self::colorToRGB( $color );

		if ( null === $rgb ) {
			return null;
		}

		if ( self::getLuminance( $rgb ) < 0.2 ) {
			// Lighten by a fixed percentage (20%)
			$rgb['r'] = min( 255, round( $rgb['r'] + ( $rgb['r'] * abs( $percent ) ) ) );
			$rgb['g'] = min( 255, round( $rgb['g'] + ( $rgb['g'] * abs( $percent ) ) ) );
			$rgb['b'] = min( 255, round( $rgb['b'] + ( $rgb['b'] * abs( $percent ) ) ) );
		} else {
			// Adjust RGB values based on the percentage
			$rgb['r'] = round( $rgb['r'] + ( $rgb['r'] * $percent ) );
			$rgb['g'] = round( $rgb['g'] + ( $rgb['g'] * $percent ) );
			$rgb['b'] = round( $rgb['b'] + ( $rgb['b'] * $percent ) );

			// Clamp values to be between 0 and 255
			$rgb['r'] = max( 0, min( 255, $rgb['r'] ) );
			$rgb['g'] = max( 0, min( 255, $rgb['g'] ) );
			$rgb['b'] = max( 0, min( 255, $rgb['b'] ) );
		}

		return 'rgb(' . implode( ',', array_values( $rgb ) ) . ')';
	}

	public static function generate_shadow_color( $color, $opacity = 0.1 ) {

		if ( false !== strpos( $color, 'var:preset|color|' ) ) {
			$preset_color_slug = str_replace( 'var:preset|color|', '', $color );
			$global_settings   = wp_get_global_settings();
			foreach ( ( $global_settings['color']['palette']['default'] ?? array() ) as $preset_data ) {
				if ( $preset_data['slug'] === $preset_color_slug ) {
					$color = $preset_data['color'];
				}
			}
			foreach ( ( $global_settings['color']['palette']['theme'] ?? array() ) as $preset_data ) {
				if ( $preset_data['slug'] === $preset_color_slug ) {
					$color = $preset_data['color'];
				}
			}
		}

		$rgb = self::colorToRGB( $color );

		if ( null === $rgb ) {
			return null;
		}

		return 'rgba(' . implode( ',', array_values( $rgb ) ) . ', ' . $opacity . ')';
	}

	// Convert RGB back to HEX
	public static function rgbToHex( $rgb ) {
		return '#' . str_pad( dechex( $rgb['r'] ), 2, '0', STR_PAD_LEFT ) .
				   str_pad( dechex( $rgb['g'] ), 2, '0', STR_PAD_LEFT ) .
				   str_pad( dechex( $rgb['b'] ), 2, '0', STR_PAD_LEFT );
	}

	// Convert RGB back to RGB string (for return to original format)
	public static function rgbToRGBString( $rgb ) {
		return "rgb({$rgb['r']}, {$rgb['g']}, {$rgb['b']})";
	}

	/**
	 * Get language url.
	 *
	 * @param string $lang Language slug.
	 * @since 1.2.9
	 */
	public static function get_language_url( $lang ) {
		if ( function_exists( 'PLL' ) && ! empty( \PLL() ) && ! empty( \PLL()->links ) && ! empty( \PLL()->model ) ) {
			return \PLL()->links->get_translation_url( \PLL()->model->get_language( $lang ) );
		}
		if ( function_exists( 'weglot_get_service' ) ) {
			$language_service     = \weglot_get_service( 'Language_Service_Weglot' );
			$request_url_services = \weglot_get_service( 'Request_Url_Service_Weglot' );
			if ( $language_service && $request_url_services ) {
				$language = $language_service->get_all_languages()[ $lang ] ?? null;
				if ( $language ) {
					return $request_url_services->get_weglot_url()->getForLanguage( $language, false );
				}
			}
		}

		global $sitepress;
		if ( ! empty( $sitepress ) ) {
			return $sitepress->language_url( $lang );
		}
		return '';
	}

	public static function get_current_language( $fallback = 'en' ) {
		if ( function_exists( 'pll_current_language' ) ) {
			return (string) pll_current_language();
		}
		if ( function_exists( 'weglot_get_current_language' ) ) {
			return \weglot_get_current_language();
		}

		global $sitepress;
		if ( ! empty( $sitepress ) ) {
			return $sitepress->get_current_language();
		}

		return $fallback;
	}

}
