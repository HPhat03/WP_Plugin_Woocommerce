<?php

namespace Brandy;

use Brandy\Core\Services\BuilderService;
use Brandy\Traits\SingletonTrait;
use Brandy\Utils\Helpers;
use Brandy\Utils\StylesDataHelpers;

class DynamicCss {

	use SingletonTrait;

	protected function __construct() {
		add_action('wp_print_scripts', array( $this, 'wp_print_scripts' ));
	}

	/**
	 * Print dynamic styles and scripts
	 */
	public function wp_print_scripts() {

		if ( is_admin() && ! is_block_editor_screen() ) {
			return;
		}

		?>
		<?php
			do_action( 'brandy_print_global_css' );
		?>
		<style id="brandy-dynamic-css">
			html {
				-ms-overflow-style: none; /* IE and Edge */
  				scrollbar-width: none; /* Firefox */
			}
			html::-webkit-scrollbar {
				display: none;
			}
			<?php 
				$this->print_dynamic_css();
			?>
		</style>
		<style id="brandy-editor-content-css">
			<?php do_action( 'brandy_print_editor_content_css' ); ?>
		</style>
	<?php
	}

	/**
	 * Process printing builder dynamic styles
	 */
	public function print_dynamic_css( ) {
		$this->print_builder_css( 'header' );
		$this->print_builder_css( 'footer' );
	}

	/**
	 * Printing styles for given builder
	 * 
	 * @param string $builder Given builder
	 */
	private function print_builder_css( $builder = 'header' ) {
		$current_template = brandy_get_builder_template( $builder );

		if ( empty( $current_template ) ) {
			return;
		}

		$all_registered_settings = BuilderService::get_all_registered_settings();

		$layouts_for_builder_configurations = $all_registered_settings[ $builder ] ?? [];

		if ( isset( $layouts_for_builder_configurations ) ) {
			$this->render_element_variables( [
				'id' => $builder,
				'settings' => $current_template['settings'],
				'builder' => $builder,
				'selector' => '#brandy-' . $builder
			], $layouts_for_builder_configurations );
		}
		
		foreach ($current_template['placements'] as $device => $placements) {
			$available_devices = [$device];
			if ( 'mobile' === $device ) {
				$available_devices[] = 'tablet';
			}
			foreach ($placements as $key => $columns) {
				if ( 'toggle' === $key ) {
					$element_ids = $columns;
					foreach ($element_ids as $element_id) {
						$element = $current_template['elements'][$element_id];
						$element['builder'] = $builder;
						$cloned_from_id = isset( $element['cloned_from'] ) ? $element['cloned_from'] : null;
						$checked_id = isset( $all_registered_settings[ $cloned_from_id ] ) ? $cloned_from_id : $element['id'];
						if ( isset( $all_registered_settings[ $checked_id ] ) ) {
							$this->render_element_variables( $element, $all_registered_settings[ $checked_id ], $available_devices );
						}
					}
				} else {
					foreach ( $columns as $col_elements ) {
						foreach ( $col_elements as $element_id ) {
							$element = $current_template['elements'][$element_id];
							$element['builder'] = $builder;
							$cloned_from_id = isset( $element['cloned_from'] ) ? $element['cloned_from'] : null;
							$checked_id = isset( $all_registered_settings[ $cloned_from_id ] ) ? $cloned_from_id : $element['id'];
							if ( isset( $all_registered_settings[ $checked_id ] ) ) {
								$this->render_element_variables( $element, $all_registered_settings[ $checked_id ], $available_devices );
							}
						}
					}
				}
			}
		}
		$row_configurations = $current_template['row_configurations'];
		foreach ($row_configurations as $row => $data) {
				$selector = '';
			if ( $row === 'toggle' ) {
				$id = 'toggle_off_canvas';
				$selector = 'body';
			} else {
				$id = $row . '_' . $builder;
				$selector = null;
			}
			if ( isset( $all_registered_settings[ $id ] ) ) {
				$this->render_element_variables( [
					'id' => $id,
					'settings' => $data,
					'builder' => $builder,
					'selector' => $selector
				], $all_registered_settings[ $id ] );
			}
		}
	}

	/**
	 * Render element variables CSS
	 */
	public function render_element_variables( $input_data, $components, $available_devices = [ 'desktop', 'tablet', 'mobile' ] ) {

		$variables = [
			'desktop' => [],
			'tablet' => [],
			'mobile' => [],
		];

		$device_css = [
			'desktop' => '',
			'tablet' => '',
			'mobile' => '',
		];

		foreach ($components as $component_data) {
			if ( isset( $component_data['render_options']['type'] ) && 'variable' === $component_data['render_options']['type'] ) {
				foreach ($component_data['render_options']['data'] as $variable_data) {
					$value = Helpers::get_nested_value( $input_data['settings'], $variable_data['value_path'], $component_data['default_value'] );
					$variables = array_merge_recursive( $variables, $this->get_variables( array_merge( $variable_data, ['value'=> $value] ), $component_data['type'] ) );
				}
			}
		}

		if ( ! empty( $input_data['selector'] ) ) {
			$selector = $input_data['selector'];
		} else {
			$selector = "[data-section-id='" . $input_data['id'] . "'][data-builder='" . $input_data['builder'] . "']";
		}

		foreach ($variables as  $device => $data) {
			$with_selector_css = [];
			foreach ($data as $sel => $css_data) {
				$key = 'root';
				if ( ! empty( $sel ) && is_string( $sel ) ) {
					$key = $sel;
					$css_data = implode( ';', $css_data );
				}
				if ( ! isset( $with_selector_css[ $key ] ) ) {
					$with_selector_css[ $key ] = [];
				}
				$with_selector_css[ $key ][] = $css_data;
			}
			if ( ! empty( $with_selector_css ) ) {
				foreach ($with_selector_css as $sel => $css_data) {
					$device_css[$device] .= ( $sel === 'root' ? $selector : ( $selector . ' ' . $sel ) ) . '{' . implode( ';', $css_data ) . '}';
				}
			}
		}

		$result = '';

		foreach ($device_css as $device => $css) {

			if ( empty( $css ) ) {
				continue;
			}

			$passed_id = $input_data['id'] . '-' . $input_data['builder'] . '-' . $device;
			global $passed_elements;

			if ( ! isset( $passed_elements ) ) {
				$passed_elements = [];
			}

			if ( ! empty( $passed_elements[ $passed_id ] ) ) {
				continue;
			}

			if ( 'desktop' === $device ) {
				$result .= $css;
				$passed_elements[ $passed_id ] = true;
				continue;
			}

			if ( ! in_array( $device, $available_devices ) ) {
				continue;
			}

			if ( ! in_array( $device, brandy_get_devices() ) ) {
				continue;
			}

			if ( 'tablet' === $device ) {
				$css = self::wrap_tablet_responsive( $css );
			}
			if ( 'mobile' === $device ) {
				$css = self::wrap_mobile_responsive( $css );
			}
			$passed_elements[ $passed_id ] = true;
			$result .= $css;
		}

		echo wp_kses_post( $result );
	}

	public function get_variables( $variable_data ) {
		if ( empty( $variable_data['type'] ) ) {
			$variable_data['type'] = '';
		}
		
		if ( 'color' === $variable_data['type'] ) {
			return $this->get_color_group_variables( $variable_data );
		}
		if ( 'typography' === $variable_data['type'] ) {
			return $this->get_typography_variables( $variable_data );
		}
		if ( 'dimension' === $variable_data['type'] ) {
			return $this->get_dimension_variables( $variable_data );
		}
		if ( 'spacing' === $variable_data['type'] ) {
			return $this->get_spacing_variables( $variable_data );
		}
		if ( 'switcher' === $variable_data['type'] ) {
			return $this->get_switcher_variables( $variable_data );
		}
		if ( 'box_shadow' === $variable_data['type'] ) {
			return $this->get_box_shadow_variables( $variable_data );
		}
		if ( 'background' === $variable_data['type'] ) {
			return $this->get_background_variables( $variable_data );
		}
		if ( 'custom_variables' === $variable_data['type'] ) {
			return $this->get_custom_variables( $variable_data );
		}
		return $this->get_normal_variables( $variable_data );
	}

	public function get_color_group_variables( $variable_data ) {
		$result = [
			'desktop' => [],
			'tablet' => [],
			'mobile' => [],
		];

		if ( empty( $variable_data['value'] ) ) {
			return $result;
		}
		$selector = $variable_data['selector'] ?? '';
		foreach ($variable_data['value'] as $color_type => $color_value) {
			if ( 'enabled_gradient' === $color_type ) {
				continue;
			}
			if ( StylesDataHelpers::is_responsive_data( $color_value ) ) {
				foreach ($color_value as $device => $variable_value) {
					if ( ! in_array( $device, brandy_get_devices() ) ) {
						continue;
					}
					$hover_value = Helpers::get_device_value( $variable_data['value']['hover'] ?? [], $device );
					$normal_value = Helpers::get_device_value( $variable_data['value']['normal'] ?? [], $device );
					if ( empty( $variable_value ) && $color_type !== 'normal' ) {
						$variable_value = $hover_value;
					}
					if ( empty( $variable_value ) ) {
						$variable_value = $normal_value;
					}
					if ( empty( $variable_value ) ) {
						$variable_value = 'currentColor';
					}
					if ( ! empty( $selector ) ) {
						if ( ! isset( $result[ $device ][$selector] ) ) {
							$result[ $device ][$selector] = [];
						}
						$result[ $device ][$selector][] = StylesDataHelpers::get_css_variable( $variable_data['name'] . '-' . $color_type, $variable_value );
					} else {
						$result[ $device ][] = StylesDataHelpers::get_css_variable( $variable_data['name'] . '-' . $color_type, $variable_value );
					}
				}
			} else {
				if ( empty( $color_value ) && $color_type !== 'normal' ) {
					$color_value = $variable_data['value']['hover'] ?? '';
				}
				if ( empty( $color_value ) ) {
					$color_value = $variable_data['value']['normal'] ?? '';
				}
				if ( empty( $color_value ) ) {
					$color_value = 'currentColor';
				}
				$variable_value = $color_value;
				if ( ! empty( $selector ) ) {
					if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
						$result['desktop'][$selector] = [];
					}
					$result[ 'desktop' ][$selector][] = StylesDataHelpers::get_css_variable($variable_data['name'] . '-' . $color_type, $color_value );
				} else {
					$result[ 'desktop' ][] = StylesDataHelpers::get_css_variable($variable_data['name'] . '-' . $color_type, $color_value );
				}
			}
		}
		return $result;
	}

	public function get_typography_variables( $variable_data ) {
		return StylesDataHelpers::get_typography_css_variables( $variable_data['value'], $variable_data['selector'] ?? '' );
	}

	public function get_dimension_variables( $variable_data ) {
		$result = [
			'desktop' => [],
			'tablet' => [],
			'mobile' => [],
		];
		$selector = $variable_data['selector'] ?? '';
		$value = $variable_data['value'];
		if ( StylesDataHelpers::is_responsive_data( $value ) ) {
			foreach ($value as $device => $variable_value) {
				if ( ! in_array( $device, brandy_get_devices() ) ) {
					continue;
				}
				$variable_value = Helpers::get_device_value( $value, $device );
				if ( ! empty( $selector ) ) {
					if ( ! isset( $result[ $device ][$selector] ) ) {
						$result[ $device ][$selector] = [];
					}
					$result[ $device ][$selector][] = StylesDataHelpers::get_dimension_css_variable($variable_data['name'], $variable_value);
				} else {
					$result[ $device ][] = StylesDataHelpers::get_dimension_css_variable($variable_data['name'], $variable_value);
				}
			}
		} else {
			if ( ! empty( $selector ) ) {

				if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
					$result[ 'desktop' ][$selector] = [];
				}

				$result[ 'desktop' ][$selector][] = StylesDataHelpers::get_dimension_css_variable($variable_data['name'], $value);
			} else {
				$result[ 'desktop' ][] = StylesDataHelpers::get_dimension_css_variable($variable_data['name'], $value);
			}
		}
		return $result;
	}

	public function get_spacing_variables( $variable_data ) {
		$result = [
			'desktop' => [],
			'tablet' => [],
			'mobile' => [],
		];
		$selector = $variable_data['selector'] ?? '';
		$value = $variable_data['value'];
		if ( StylesDataHelpers::is_responsive_data( $value ) ) {
			foreach ($value as $device => $variable_value) {
				if ( ! in_array( $device, brandy_get_devices() ) ) {
					continue;
				}
				$variable_value = Helpers::get_device_value( $value, $device );
				if ( ! empty( $selector ) ) {
					if ( ! isset( $result[ $device ][$selector] ) ) {
						$result[ $device ][$selector] = [];
					}

					$result[ $device ][$selector][] = StylesDataHelpers::get_spacing_css_variable( $variable_data['name'], $variable_value );
				} else {
					$result[ $device ][] = StylesDataHelpers::get_spacing_css_variable( $variable_data['name'], $variable_value );
				}
				// $result[ $device ] = array_merge($result[ $device ], StylesDataHelpers::get_directions_spacing_css_variables($variable_data['name'], $variable_value ));
			}
		} else {
			if ( ! empty( $selector ) ) {
				if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
					$result[ 'desktop' ][$selector] = [];
				}
				$result[ 'desktop' ][$selector][] = StylesDataHelpers::get_spacing_css_variable($variable_data['name'], $value);
			} else {
				$result[ 'desktop' ][] = StylesDataHelpers::get_spacing_css_variable($variable_data['name'], $value);
			}
			// $result[ 'desktop' ] = array_merge($result[ 'desktop'], StylesDataHelpers::get_directions_spacing_css_variables($variable_data['name'], $value ));
		}
		return $result;
	}

	public function get_switcher_variables( $variable_data ) {
		$result = [
			'desktop' => [],
			'tablet' => [],
			'mobile' => [],
		];
		$selector = $variable_data['selector'] ?? '';
		$value = $variable_data['value'];
		if ( StylesDataHelpers::is_responsive_data( $value ) ) {
			foreach ($value as $device => $variable_value) {
				if ( ! in_array( $device, brandy_get_devices() ) ) {
					continue;
				}
				$variable_value = Helpers::get_device_value( $value, $device );
				if ( ! empty( $selector ) ) {
					if ( ! isset( $result[ $device ][$selector] ) ) {
						$result[ $device ][$selector] = [];
					}
					$result[ $device ][$selector][] = StylesDataHelpers::get_css_variable( $variable_data['name'], $variable_value ? $variable_data['enabled_value'] : $variable_data['disabled_value'] );
				} else {
					$result[ $device ][] = StylesDataHelpers::get_css_variable( $variable_data['name'], $variable_value ? $variable_data['enabled_value'] : $variable_data['disabled_value'] );
				}
			}
		} else {
			if ( ! empty( $selector ) ) {
				if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
					$result[ 'desktop' ][$selector] = [];
				}
				$result[ 'desktop' ][$selector][] = StylesDataHelpers::get_css_variable( $variable_data['name'], $value ? $variable_data['enabled_value'] : $variable_data['disabled_value'] );
			} else {
				$result[ 'desktop' ][] = StylesDataHelpers::get_css_variable( $variable_data['name'], $value ? $variable_data['enabled_value'] : $variable_data['disabled_value'] );
			}
		}
		return $result;
	}

	public function get_box_shadow_variables( $variable_data ) {
		$result = [
			'desktop' => [],
			'tablet' => [],
			'mobile' => [],
		];
		$selector = $variable_data['selector'] ?? '';
		$value = $variable_data['value'];
		if ( StylesDataHelpers::is_responsive_data( $value ) ) {
			foreach ($value as $device => $variable_value) {
				if ( ! in_array( $device, brandy_get_devices() ) ) {
					continue;
				}
				$variable_value = Helpers::get_device_value( $value, $device );
				if ( ! empty( $selector ) ) {

					if ( ! isset( $result[ $device ][$selector] ) ) {
						$result[ $device ][$selector] = [];
					}

					$result[ $device ][$selector][] = StylesDataHelpers::get_box_shadow_css_variable( $variable_data['name'], $variable_value );
				} else {
					$result[ $device ][] = StylesDataHelpers::get_box_shadow_css_variable( $variable_data['name'], $variable_value );
				}
			}
		} else {
			if ( ! empty( $selector ) ) {

				if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
					$result[ 'desktop' ][$selector] = [];
				}

				$result[ 'desktop' ][$selector] []= StylesDataHelpers::get_box_shadow_css_variable( $variable_data['name'], $value );
			} else {
				$result[ 'desktop' ][] = StylesDataHelpers::get_box_shadow_css_variable( $variable_data['name'], $value );
			}
		}
		return $result;
	}

	public function get_background_variables( $variable_data ) {
		$selector = $variable_data['selector'] ?? '';
		$result = [
			'desktop' => [],
			'tablet' => [],
			'mobile' => [],
		];
		$value = $variable_data['value'];
		if ( 'solid' === $value['type'] ) {
			$color = StylesDataHelpers::get_css_variable($variable_data['name'] . '-main', $value['solid_color']);
		}
		if ( 'gradient' === $value['type'] ) {
			$color = StylesDataHelpers::get_css_variable($variable_data['name'] . '-main', $value['gradient_color']);
		}
		if ( 'image' === $value['type'] ) {
			$image_data = $value['image'];
			$color = StylesDataHelpers::get_css_variable($variable_data['name'] . '-main', 'url(' . $image_data['url'] . ')');
			$overlay_color = StylesDataHelpers::get_css_variable($variable_data['name'] . '-overlay-color', $image_data['overlay_color']);
			$size = StylesDataHelpers::get_css_variable($variable_data['name'] . '-size', $image_data['size']);
			$position = StylesDataHelpers::get_css_variable($variable_data['name'] . '-position', 'custom' === $image_data['position'] ? StylesDataHelpers::get_dimension_css( $image_data['left'] ) . ' ' . StylesDataHelpers::get_dimension_css( $image_data['top'] ) : $image_data['position']);
		}
		if ( ! empty( $color ) ) {
			if ( ! empty( $selector ) ) {
				if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
					$result[ 'desktop' ][$selector] = [];
				}
					
				$result[ 'desktop' ][$selector][] = $color;
			} else {
				$result[ 'desktop' ][] = $color;
			}
		}
		if ( ! empty( $overlay_color ) ) {
			if ( ! empty( $selector ) ) {
				if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
					$result[ 'desktop' ][$selector] = [];
				}

				$result[ 'desktop' ][$selector][] = $overlay_color;
			} else {
				$result[ 'desktop' ][] = $overlay_color;
			}
		}
		if ( ! empty( $size ) ) {
			if ( ! empty( $selector ) ) {
				$result[ 'desktop' ][$selector][] = $size;
			} else {
				$result[ 'desktop' ][] = $size;
			}
		}
		if ( ! empty( $position ) ) {
			if ( ! empty( $selector ) ) {
				if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
					$result[ 'desktop' ][$selector] = [];
				}

				$result[ 'desktop' ][$selector][] = $position;
			} else {
				$result[ 'desktop' ][] = $position;
			}
		}
		return $result;
	}

	public function get_normal_variables( $variable_data ) {
		$result = [
			'desktop' => [],
			'tablet' => [],
			'mobile' => [],
		];
		$value = $variable_data['value'];
		$selector = $variable_data['selector'] ?? '';
		if ( StylesDataHelpers::is_responsive_data( $value ) ) {
			foreach ($value as $device => $variable_value) {
				if ( ! in_array( $device, brandy_get_devices() ) ) {
					continue;
				}
				$variable_value = Helpers::get_device_value( $value, $device );
				if ( is_string( $variable_value ) ) {
					$v = StylesDataHelpers::get_css_variable( $variable_data['name'], $variable_value );
					if ( ! empty( $selector ) ) {

						if ( ! isset( $result[ $device ][$selector] ) ) {
							$result[ $device ][$selector] = [];
						}

						$result[ $device ][$selector][] = $v;
					} else {
						$result[ $device ][] = $v;
					}
				}
			}
		} else {
			if ( is_string( $value ) || is_numeric( $value ) ) {
				if ( ! empty( $selector ) ) {

					if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
						$result[ 'desktop' ][$selector] = [];
					}

					$result[ 'desktop' ][$selector][] = StylesDataHelpers::get_css_variable($variable_data['name'], $value);
				} else {
					$result[ 'desktop' ][] = StylesDataHelpers::get_css_variable($variable_data['name'], $value);
				}
			}
		}
		return $result;
	}

	public function get_custom_variables( $variable_data ) {
		$result = [
			'desktop' => [],
			'tablet' => [],
			'mobile' => [],
		];
		$selector = $variable_data['selector'] ?? '';
		if ( ! empty( $variable_data['mapping_variables'] ) ) {
			foreach ( $variable_data['mapping_variables'] as $mapping_variable ) {
				$comparison_operator = $mapping_variable['condition']['operator'];
				$path = $mapping_variable['path'];
				if ( empty( $path ) ) {
					$check_value = $variable_data['value'];
				} else {
					$check_value = Helpers::get_nested_value( $variable_data['value'], $path );
					if ( is_null( $check_value ) ) {
						$device_position = array_search( 'mobile', $path );
						if ( false !== $device_position ) {
							$path[ $device_position ] = 'tablet';
							$check_value = Helpers::get_nested_value( $variable_data['value'], $path );
						}
					}
					if ( is_null( $check_value ) ) {
						$device_position = array_search( 'tablet', $path );
						if ( false !== $device_position ) {
							$path[ $device_position ] = 'desktop';
							$check_value = Helpers::get_nested_value( $variable_data['value'], $path );
						}
					}
				}
				if ( ! isset( $check_value ) || is_null( $check_value ) ) {
					continue;
				}
				$check = false;
				if ( 'equal' === $comparison_operator && $check_value == $mapping_variable['condition']['value'] ) {
					$check = true;
				}
				if ( 'not_equal' === $comparison_operator && $check_value != $mapping_variable['condition']['value'] ) {
					$check = true;
				}
				if ( 'contains' === $comparison_operator && strpos( $check_value, $mapping_variable['condition']['value'] ) !== false ) {
					$check = true;
				}
				if ( 'not_contains' === $comparison_operator && strpos( $check_value, $mapping_variable['condition']['value'] ) === false ) {
					$check = true;
				}
				if ( 'in_array' === $comparison_operator && in_array( $check_value, $mapping_variable['condition']['value'] ) ) {
					$check = true;
				}
				if ( 'not_in_array' === $comparison_operator && ! in_array( $check_value, $mapping_variable['condition']['value'] ) ) {
					$check = true;
				}
				if ( ! $check ) {
					continue;
				}
				foreach ( $mapping_variable['mapping'] as $device => $variable_value ) {
					foreach ( $variable_value as $v_name => $v_value ) {
						$v = StylesDataHelpers::get_css_variable( $v_name, $v_value );
						if ( ! empty( $selector ) ) {
							if ( ! isset( $result[ $device ][$selector] ) ) {
								$result[ $device ][$selector] = [];
							}
							$result[ $device ][$selector][] = $v;
						} else {
							$result[ $device ][] = $v;
						}
					}
				}
			}
		} else {
			$variable_name = $variable_data['name'];
			$variable_value = $variable_data['value'];
			$v = StylesDataHelpers::get_css_variable( $variable_name, $variable_value );
			if ( ! empty( $selector ) ) {
				if ( ! isset( $result[ 'desktop' ][$selector] ) ) {
					$result[ 'desktop' ][$selector] = [];
				}
				$result[ 'desktop' ][$selector][] = $v;
			} else {
				$result[ 'desktop' ][] = $v;
			}
		}
		
		return $result;
	}

	public static function wrap_tablet_responsive( $css ) {
		return '@media screen and (min-width: ' . (BRANDY_MOBILE_MAX_WIDTH + 1) . 'px) and (max-width:  ' . BRANDY_TABLET_MAX_WIDTH . 'px) {' . $css . '}';
	}
	public static function wrap_mobile_responsive( $css ) {
		return '@media screen and (max-width: ' . BRANDY_MOBILE_MAX_WIDTH . 'px) {' . $css . '}';
	}

}