<?php

namespace Brandy\Customizer\Layouts;

use Brandy\Abstracts\AbstractLayout;
use Brandy\Builder\RowBuilder;
use Brandy\Traits\SingletonTrait;

class FooterRowSettings extends AbstractLayout {

	use SingletonTrait;

	protected $components = array();

	private $rows = array();

	protected function __construct() {

		$this->rows = array(
			'top'    => array(
				'title' => __( 'Top footer', 'brandy' ),
			),
			'middle' => array(
				'title' => __( 'Middle footer', 'brandy' ),
			),
			'bottom' => array(
				'title' => __( 'Bottom footer', 'brandy' ),
			),

		);
		parent::__construct();

	}

	public function add_layout( $layouts = array() ) {
		$layout = array(
			'general' => array(
				'sections' => array(
					array(
						'components' => array(
							'number_column',
							'row_direction',
							'column_layout_1',
							'column_layout_2',
							'column_layout_3',
							'column_layout_4',
							'column_layout_5',
							'column_layout_6',
						),
					),
					array(
						'components' => array( 'column_spacing' ),
					),
					array(
						'components' => array( 'column_items_direction' ),
					),
					array(
						'components' => array( 'height' ),
					),
					// array(
					// 	'components' => array( 'split_container', 'children_padding' ),
					// ),
					array(
						'components' => array( 'enabled_devices' ),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array( 'is_constrained' ),
					),
					array(
						'components' => array( 'background' ),
					),
					array(
						'components' => array( 'top_stroke_reset', 'top_stroke_color', 'top_stroke_width' ),
					),
					array(
						'components'         => array(
							'column_span',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'hidden' ),
								'value'      => false,
							),
						),
					),
					array(
						'components' => array( 'border_radius' ),
					),
					array(
						'components' => array( 'padding' ),
					),
					array(
						'components' => array( 'margin' ),
					),
					array(
						'components' => array( 'outside_margin' ),
					),
				),
			),
		);
		$mapped_layout = $this->map_layout( $layout );
		foreach ( array_keys( $this->rows ) as $row ) {
			$id             = $row . '_footer';
			$layouts[ $id ] = $mapped_layout;
		}
		return $layouts;
	}

	public function add_registered_settings( $settings = array() ) {
		foreach ( array_keys( $this->rows ) as $row ) {
			$id              = $row . '_footer';
			$settings[ $id ] = $this->components;
		}
		return $settings;
	}

	protected function register_components() {
		return array(
			'is_constrained'                 => array(
				'title'          => array(
					'text' => __( 'Apply styles to content box', 'brandy' ),
					'type' => 'bold',
				),
				'description'    => __( 'Apply styles (background, border) to the content box of the footer row.', 'brandy' ),
				'type'           => 'Switcher',
				'default_value'  => false,
				'value_path'     => array( 'is_constrained' ),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '',
							'name'       => 'data-is-constrained',
							'value_path' => array( 'is_constrained' ),
						),
					),
				),
			),
			'number_column'                  => array(
				'title'          => array(
					'text'         => __( 'Columns per row', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'           => 'FooterNumberColumn',
				'default_value'  => array(
					'desktop' => 3,
					'tablet'  => 3,
					'mobile'  => 3,
				),
				'options'        => array(
					array(
						'label' => 1,
						'value' => 1,
					),
					array(
						'label' => 2,
						'value' => 2,
					),
					array(
						'label' => 3,
						'value' => 3,
					),
					array(
						'label' => 4,
						'value' => 4,
					),
					array(
						'label' => 5,
						'value' => 5,
					),
					array(
						'label' => 6,
						'value' => 6,
					),
				),
				'value_path'     => array( 'number_column' ),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'column_layout_1'                => array(
				'title'              => array(
					'text' => __( 'Column Layout', 'brandy' ),
					'type' => 'normal',
				),
				'type'               => 'FooterColumnLayout',
				'visible_conditions' => array(
					array(
						'value_path' => array( 'number_column' ),
						'value'      => 1,
					),
					array(
						'value_path' => array( 'row_direction' ),
						'value'      => 'horizontal',
					),
				),
			),
			'column_layout_2'                => array(
				'title'              => array(
					'text' => __( 'Column Layout', 'brandy' ),
					'type' => 'normal',
				),
				'type'               => 'FooterColumnLayout',
				'visible_conditions' => array(
					array(
						'value_path' => array( 'number_column' ),
						'value'      => 2,
					),
					array(
						'value_path' => array( 'row_direction' ),
						'value'      => 'horizontal',
					),
				),
			),
			'column_layout_3'                => array(
				'title'              => array(
					'text' => __( 'Column Layout', 'brandy' ),
					'type' => 'normal',
				),
				'type'               => 'FooterColumnLayout',
				'visible_conditions' => array(
					array(
						'value_path' => array( 'number_column' ),
						'value'      => 3,
					),
					array(
						'value_path' => array( 'row_direction' ),
						'value'      => 'horizontal',
					),
				),
			),
			'column_layout_4'                => array(
				'title'              => array(
					'text' => __( 'Column Layout', 'brandy' ),
					'type' => 'normal',
				),
				'type'               => 'FooterColumnLayout',
				'visible_conditions' => array(
					array(
						'value_path' => array( 'number_column' ),
						'value'      => 4,
					),
					array(
						'value_path' => array( 'row_direction' ),
						'value'      => 'horizontal',
					),
				),
			),
			'column_layout_5'                => array(
				'title'              => array(
					'text' => __( 'Column Layout', 'brandy' ),
					'type' => 'normal',
				),
				'type'               => 'FooterColumnLayout',
				'visible_conditions' => array(
					array(
						'value_path' => array( 'number_column' ),
						'value'      => 5,
					),
					array(
						'value_path' => array( 'row_direction' ),
						'value'      => 'horizontal',
					),
				),
			),
			'column_layout_6'                => array(
				'title'              => array(
					'text' => __( 'Column Layout', 'brandy' ),
					'type' => 'normal',
				),
				'type'               => 'FooterColumnLayout',
				'visible_conditions' => array(
					array(
						'value_path' => array( 'number_column' ),
						'value'      => 6,
					),
					array(
						'value_path' => array( 'row_direction' ),
						'value'      => 'horizontal',
					),
				),
			),
			'column_spacing'                 => array(
				'title'          => array(
					'text'         => __( 'Column Spacing', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'           => 'Dimension',
				'value_path'     => array( 'column_spacing' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 20,
						'min'   => 10,
						'max'   => 200,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--brandy-spacing',
							'value_path' => array( 'column_spacing' ),
						),
					),
				),
			),
			'row_direction'                  => array(
				'title'          => array(
					'text' => __( 'Item flow direction', 'brandy' ),
				),
				'description'    => __( 'This will restrict child width if parent is boxed layout', 'brandy' ),
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'value' => 'horizontal',
						'label' => __( 'Left to Right', 'brandy' ),
					),
					array(
						'value' => 'vertical',
						'label' => __( 'Top to Bottom', 'brandy' ),
					),
				),
				'default_value'  => array(
					'desktop' => 'horizontal',
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'row_direction' ),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.footer-container',
							'name'       => 'data-desktop-direction',
							'value_path' => array( 'row_direction', 'desktop' ),
						),
						array(
							'selector'   => '.footer-container',
							'name'       => 'data-tablet-direction',
							'value_path' => array( 'row_direction', 'tablet' ),
						),
						array(
							'selector'   => '.footer-container',
							'name'       => 'data-mobile-direction',
							'value_path' => array( 'row_direction', 'mobile' ),
						),
					),
				),
			),
			'column_items_direction'         => array(
				'title'          => array(
					'text' => __( 'Direction', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'ColumnContentLayout',
				'options'        => array(
					array(
						'label' => __( 'Horizontal', 'brandy' ),
						'value' => 'row',
					),
					array(
						'label' => __( 'Vertical', 'brandy' ),
						'value' => 'column',
					),
				),
				'default_value'  => array(
					'desktop' => array(
						'column_1' => 'horizontal',
						'column_2' => 'horizontal',
						'column_3' => 'horizontal',
						'column_4' => 'horizontal',
						'column_5' => 'horizontal',
						'column_6' => 'horizontal',
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'column_items_direction' ),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array_reduce(
						array( 1, 2, 3, 4, 5, 6 ),
						function( $carry, $col ) {
							return array_merge(
								$carry,
								array_map(
									function( $device ) use ( $col ) {
										return array(
											'name'       => "data-items-direction-$device",
											'value_path' => array( 'column_items_direction', $device, "column_$col" ),
										);
									},
									brandy_get_devices()
								)
							);
						},
						array()
					),
				),
			),
			'column_vertical_alignment'      => array(
				'title'          => array(
					'text' => __( 'Vertical alignment', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => '',
				'value_path'     => array( 'column_vertical_alignment' ),
				'default_value'  => array(
					'desktop' => array(
						'column_1' => 'center',
						'column_2' => 'center',
						'column_3' => 'center',
						'column_4' => 'center',
						'column_5' => 'center',
						'column_6' => 'center',
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array_map(
						function( $col ) {
							return array(
								'type'              => 'custom_variables',
								'value_path'        => array( 'column_vertical_alignment' ),
								'selector'          => ".footer-container .footer-col:nth-child($col)",
								'mapping_variables' => array_merge(
									array_map(
										function( $device ) use ( $col ) {
											return array(
												'condition' => array(
													'operator' => 'equal',
													'value'    => 'center',
												),
												'path'    => array( $device, "column_$col" ),
												'mapping' => array(
													$device => array(
														"--brandy-footer-column-vertical-alignment-$device" => 'center',
													),
												),
											);
										},
										brandy_get_devices()
									),
									array_map(
										function( $device ) use ( $col ) {
											return array(
												'condition' => array(
													'operator' => 'equal',
													'value'    => 'flex-start',
												),
												'path'    => array( $device, "column_$col" ),
												'mapping' => array(
													$device => array(
														"--brandy-footer-column-vertical-alignment-$device" => 'flex-start',
													),
												),
											);
										},
										brandy_get_devices()
									),
									array_map(
										function( $device ) use ( $col ) {
											return array(
												'condition' => array(
													'operator' => 'equal',
													'value'    => 'flex-end',
												),
												'path'    => array( $device, "column_$col" ),
												'mapping' => array(
													$device => array(
														"--brandy-footer-column-vertical-alignment-$device" => 'flex-end',
													),
												),
											);
										},
										brandy_get_devices()
									),
									array_map(
										function( $device ) use ( $col ) {
											return array(
												'condition' => array(
													'operator' => 'equal',
													'value'    => 'space-between',
												),
												'path'    => array( $device, "column_$col" ),
												'mapping' => array(
													$device => array(
														"--brandy-footer-column-vertical-alignment-$device" => 'space-between',
													),
												),
											);
										},
										brandy_get_devices()
									)
								),
							);
						},
						array( 1, 2, 3, 4, 5, 6 )
					),
				),
			),
			'column_horizontal_alignment'    => array(
				'title'          => array(
					'text' => __( 'Horizontal Alignment', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => '',
				'value_path'     => array( 'column_horizontal_alignment' ),
				'default_value'  => array(
					'desktop' => array(
						'column_1' => 'flex-start',
						'column_2' => 'flex-start',
						'column_3' => 'flex-start',
						'column_4' => 'flex-start',
						'column_5' => 'flex-start',
						'column_6' => 'flex-start',
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array_map(
						function( $col ) {
							return array(
								'type'              => 'custom_variables',
								'value_path'        => array( 'column_horizontal_alignment' ),
								'selector'          => ".footer-container .footer-col:nth-child($col)",
								'mapping_variables' => array_merge(
									array_map(
										function( $device ) use ( $col ) {
											return array(
												'condition' => array(
													'operator' => 'equal',
													'value'    => 'center',
												),
												'path'    => array( $device, "column_$col" ),
												'mapping' => array(
													$device => array(
														"--brandy-footer-column-horizontal-alignment-$device" => 'center',
													),
												),
											);
										},
										brandy_get_devices()
									),
									array_map(
										function( $device ) use ( $col ) {
											return array(
												'condition' => array(
													'operator' => 'equal',
													'value'    => 'flex-start',
												),
												'path'    => array( $device, "column_$col" ),
												'mapping' => array(
													$device => array(
														"--brandy-footer-column-horizontal-alignment-$device" => 'flex-start',
													),
												),
											);
										},
										brandy_get_devices()
									),
									array_map(
										function( $device ) use ( $col ) {
											return array(
												'condition' => array(
													'operator' => 'equal',
													'value'    => 'space-between',
												),
												'path'    => array( $device, "column_$col" ),
												'mapping' => array(
													$device => array(
														"--brandy-footer-column-horizontal-alignment-$device" => 'space-between',
													),
												),
											);
										},
										brandy_get_devices()
									),
									array_map(
										function( $device ) use ( $col ) {
											return array(
												'condition' => array(
													'operator' => 'equal',
													'value'    => 'flex-end',
												),
												'path'    => array( $device, "column_$col" ),
												'mapping' => array(
													$device => array(
														"--brandy-footer-column-horizontal-alignment-$device" => 'flex-end',
													),
												),
											);
										},
										brandy_get_devices()
									)
								),
							);
						},
						array( 1, 2, 3, 4, 5, 6 )
					),
				),
			),
			'column_item_horizontal_spacing' => array(
				'title'          => array(
					'text' => __( 'Column item spacing', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => '',
				'value_path'     => array( 'column_item_horizontal_spacing' ),
				'default_value'  => array(
					'desktop' => array(
						'column_1' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_2' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_3' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_4' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_5' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_6' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array_reduce(
						array( 1, 2, 3, 4, 5, 6 ),
						function( $carry, $col ) {
							return array_merge(
								$carry,
								array_map(
									function( $device ) use ( $col ) {
										return array(
											'type'       => 'dimension',
											'selector'   => ".footer-container .footer-col:nth-child($col)",
											'name'       => "--brandy-footer-column-item-horizontal-spacing-$device",
											'value_path' => array( 'column_item_horizontal_spacing', $device, "column_$col" ),
										);
									},
									brandy_get_devices()
								)
							);
						},
						array()
					),
				),
			),
			'column_item_vertical_spacing'   => array(
				'title'          => array(
					'text' => __( 'Column item spacing', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => '',
				'value_path'     => array( 'column_item_vertical_spacing' ),
				'default_value'  => array(
					'desktop' => array(
						'column_1' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_2' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_3' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_4' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_5' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
						'column_6' => array(
							'value' => 12,
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 200,
						),
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array_reduce(
						array( 1, 2, 3, 4, 5, 6 ),
						function( $carry, $col ) {
							return array_merge(
								$carry,
								array_map(
									function( $device ) use ( $col ) {
										return array(
											'type'       => 'dimension',
											'selector'   => ".footer-container .footer-col:nth-child($col)",
											'name'       => "--brandy-footer-column-item-vertical-spacing-$device",
											'value_path' => array( 'column_item_vertical_spacing', $device, "column_$col" ),
										);
									},
									brandy_get_devices()
								)
							);
						},
						array()
					),
				),
			),
			'column_span'                    => array(
				'title'          => array(
					'text' => __( 'Column span', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'NumberInput',
				'value_path'     => array( 'column_span' ),
				'default_value'  => array(
					'desktop' => array(
						'column_1' => 1,
						'column_2' => 1,
						'column_3' => 1,
						'column_4' => 1,
						'column_5' => 1,
						'column_6' => 1,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array_reduce(
						array( 1, 2, 3, 4, 5, 6 ),
						function( $carry, $col ) {
							return array_merge(
								$carry,
								array_map(
									function( $device ) use ( $col ) {
										return array(
											'type'       => 'custom',
											'selector'   => ".footer-container .footer-col:nth-child($col)",
											'name'       => "--brandy-footer-column-span-$device",
											'value_path' => array( 'column_span', $device, "column_$col" ),
										);
									},
									brandy_get_devices()
								)
							);
						},
						array()
					),
				),
			),
			'column_item_grow'               => array(
				'title'          => array(
					'text' => __( 'Item grow', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => '',
				'value_path'     => array( 'column_item_grow' ),
				'default_value'  => array(
					'desktop' => array(
						'column_1' => 'auto',
						'column_2' => 'auto',
						'column_3' => 'auto',
						'column_4' => 'auto',
						'column_5' => 'auto',
						'column_6' => 'auto',
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array_reduce(
						array( 1, 2, 3, 4, 5, 6 ),
						function( $carry, $col ) {
							return array_merge(
								$carry,
								array_map(
									function( $device ) use ( $col ) {
										return array(
											'type'       => 'custom',
											'selector'   => ".footer-container .footer-col:nth-child($col)",
											'name'       => "--brandy-footer-column-item-grow-$device",
											'value_path' => array( 'column_item_grow', $device, "column_$col" ),
										);
									},
									brandy_get_devices()
								)
							);
						},
						array()
					),
				),
			),
			'column_flex_wrap'               => array(
				'title'          => array(
					'text'    => __( 'Flex Wrap', 'brandy' ),
					'type'    => 'bold',
					'tooltip' => __( 'Wrap elements onto multiple lines', 'brandy' ),
				),
				'type'           => '',
				'value_path'     => array( 'column_flex_wrap' ),
				'default_value'  => array(
					'desktop' => array(
						'column_1' => true,
						'column_2' => true,
						'column_3' => true,
						'column_4' => true,
						'column_5' => true,
						'column_6' => true,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array_reduce(
						array( 1, 2, 3, 4, 5, 6 ),
						function( $carry, $col ) {
							return array_merge(
								$carry,
								array_map(
									function( $device ) use ( $col ) {
										return array(
											'type'       => 'switcher',
											'selector'   => ".footer-container .footer-col:nth-child($col)",
											'name'       => "--brandy-footer-column-flex-wrap-$device",
											'value_path' => array( 'column_flex_wrap', $device, "column_$col" ),
											'default'    => 'wrap',
											'enabled_value' => 'wrap',
											'disabled_value' => 'nowrap',
										);
									},
									brandy_get_devices()
								)
							);
						},
						array()
					),
				),
			),
			'enabled_devices'                => array(
				'value_path'     => array( 'enabled_devices' ),
				'title'          => array(
					'text' => __( 'Visible on', 'brandy' ),
					'type' => 'bold',
				),
				'default_value'  => array( 'desktop', 'mobile' ),
				'type'           => 'EnabledDevices',
				'render_options' => array(
					'type'     => 'custom',
					'selector' => '',
				),
			),
			'background'                     => array(
				'value_path'     => array( 'background' ),
				'title'          => array(
					'text' => __( 'Background', 'brandy' ),
					'type' => 'bold',
				),
				'default_value'  => array(
					'type'           => 'solid',
					'solid_color'    => '#ffffff',
					'gradient_color' => 'linear-gradient(90deg, RGBA(27, 60, 221, 1) 0%, rgba(251,208,238,1) 100%)',
					'image'          => array(
						'url'           => '',
						'top'           => array(
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 100,
							'value' => 0,
						),
						'left'          => array(
							'unit'  => 'px',
							'min'   => 0,
							'max'   => 100,
							'value' => 0,
						),
						'overlay_color' => '#fff',
						'size'          => 'auto',
						'position'      => 'left',
					),
				),
				'type'           => 'Background',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'background',
							'name'       => '--brandy-background',
							'value_path' => array( 'background' ),
						),
					),
				),
			),
			'split_container'                => array(
				'value_path'     => array( 'split_container' ),
				'title'          => array(
					'text'    => __( 'Split children container', 'brandy' ),
					'type'    => 'bold',
					'tooltip' => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					viewBox="0 0 675.4 207.6" style="enable-background:new 0 0 675.4 207.6;" xml:space="preserve">
			   <style type="text/css">
				   .b-c-1{fill:#8CBDFF;}
				   .bc-2{fill:#FFFFFF;}
				   .bc-3{fill:#004972;}
			   </style>
			   <g>
				   <path class="b-c-1" d="M660.4,81.3H61c-6.6,0-12-5.4-12-12V15.6c0-6.6,5.4-12,12-12h599.4c6.6,0,12,5.4,12,12v53.7
					   C672.4,76,667,81.3,660.4,81.3z"/>
				   <path class="bc-2" d="M173.2,52.1h-83c-5.3,0-9.6-4.3-9.6-9.6v0c0-5.3,4.3-9.6,9.6-9.6h83c5.3,0,9.6,4.3,9.6,9.6v0
					   C182.8,47.8,178.5,52.1,173.2,52.1z"/>
				   <path class="b-c-1" d="M340.7,204H61c-6.6,0-12-5.4-12-12v-53.7c0-6.6,5.4-12,12-12h279.7c6.6,0,12,5.4,12,12V192
					   C352.7,198.6,347.3,204,340.7,204z"/>
				   <path class="bc-2" d="M173.2,174.8h-83c-5.3,0-9.6-4.3-9.6-9.6v0c0-5.3,4.3-9.6,9.6-9.6h83c5.3,0,9.6,4.3,9.6,9.6v0
					   C182.8,170.5,178.5,174.8,173.2,174.8z"/>
				   <path class="b-c-1" d="M660.4,204H380.7c-6.6,0-12-5.4-12-12v-53.7c0-6.6,5.4-12,12-12h279.7c6.6,0,12,5.4,12,12V192
					   C672.4,198.6,667,204,660.4,204z"/>
				   <path class="bc-2" d="M492.9,174.8h-83c-5.3,0-9.6-4.3-9.6-9.6v0c0-5.3,4.3-9.6,9.6-9.6h83c5.3,0,9.6,4.3,9.6,9.6v0
					   C502.5,170.5,498.2,174.8,492.9,174.8z"/>
				   <path class="bc-2" d="M492.9,52.1h-83c-5.3,0-9.6-4.3-9.6-9.6v0c0-5.3,4.3-9.6,9.6-9.6h83c5.3,0,9.6,4.3,9.6,9.6v0
					   C502.5,47.8,498.2,52.1,492.9,52.1z"/>
			   </g>
			   <g>
				   <g>
					   <path class="bc-3" d="M30.5,139.1c-0.9,0-1.8-0.4-2.4-1.1c-0.8-0.9-19.6-22.2-16.4-45.1c1.7-11.9,8.9-21.9,21.4-29.7
						   c1.5-1,3.5-0.5,4.5,1c1,1.5,0.5,3.5-1,4.5c-10.8,6.8-17,15.2-18.4,25.1c-2.8,19.9,14.6,39.7,14.8,39.9c1.2,1.3,1.1,3.4-0.3,4.6
						   C32,138.9,31.3,139.1,30.5,139.1z"/>
				   </g>
				   <g>
					   <path class="bc-3" d="M35.2,144.9c-0.4,0-0.7-0.1-1.1-0.2l-22.5-8.1c-1.7-0.6-2.6-2.5-2-4.2c0.6-1.7,2.5-2.6,4.2-2l17.7,6.4
						   L30,117.7c-0.1-1.8,1.2-3.4,3-3.5c1.8-0.2,3.4,1.2,3.5,3l2,24.3c0.1,1.1-0.4,2.2-1.3,2.8C36.6,144.7,35.9,144.9,35.2,144.9z"/>
				   </g>
			   </g>
			   </svg>
			   ',
				),
				'description'    => '',
				'default_value'  => false,
				'type'           => 'Switcher',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'type'           => 'switcher',
							'name'           => 'data-split-container',
							'selector'       => '',
							'value_path'     => array( 'split_container' ),
							'enabled_value'  => 'true',
							'disabled_value' => 'false',
						),
					),
				),
			),
			'children_padding'               => array(
				'value_path'         => array( 'children_padding' ),
				'title'              => array(
					'text'         => 'Children padding',
					'show_devices' => true,
				),
				'default_value'      => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 10,
						'right'          => 10,
						'bottom'         => 10,
						'left'           => 10,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'               => 'Spacing',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => '--brandy-footer-row-children-padding',
							'value_path' => array( 'children_padding' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'split_container' ),
						'value'      => true,
					),
				),
			),
			'top_stroke_reset'               => array(
				'type'         => 'Reset',
				'title'        => array(
					'text' => __( 'Top stroke', 'brandy' ),
					'type' => 'bold',
				),
				'reset_action' => 'row_settings',
				'reset_paths'  => array(
					array( 'top_stroke' ),
				),
			),
			'top_stroke_color'               => array(
				'type'           => 'ColorGroup',
				'title'          => array(
					'text' => __( 'Color', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'top_stroke', 'color' ),
				'default_value'  => array(
					'normal' => '#e2e9fb',
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--brandy-stroke-color',
							'value_path' => array( 'top_stroke', 'color' ),
						),
					),
				),
			),
			'top_stroke_width'               => array(
				'type'           => 'Dimension',
				'title'          => array(
					'text' => __( 'Width', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'top_stroke', 'width' ),
				'default_value'  => array(
					'unit'  => 'px',
					'min'   => 0,
					'max'   => 20,
					'value' => 0,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--brandy-stroke-width',
							'value_path' => array( 'top_stroke', 'width' ),
						),
					),
				),
			),
			'padding'                        => array(
				'value_path'     => array( 'padding' ),
				'title'          => array(
					'text'         => 'Padding',
					'type'         => 'bold',
					'show_devices' => true,
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 0,
						'right'          => 0,
						'bottom'         => 0,
						'left'           => 0,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => '--brandy-footer-row-padding',
							'value_path' => array( 'padding' ),
						),
					),
				),
			),
			'margin'                         => array(
				'value_path'     => array( 'margin' ),
				'title'          => array(
					'text'         => 'Outer padding',
					'type'         => 'bold',
					'show_devices' => true,
				),
				'default_value'  => array(
					'desktop' => array(
						'show_devices'   => true,
						'unit'           => 'px',
						'top'            => 0,
						'right'          => 0,
						'bottom'         => 0,
						'left'           => 0,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => '--brandy-footer-row-outside-padding',
							'value_path' => array( 'margin' ),
						),
					),
				),
			),
			'outside_margin'                 => array(
				'value_path'     => array( 'outside_margin' ),
				'title'          => array(
					'text'         => 'Outer margin',
					'type'         => 'bold',
					'show_devices' => true,
				),
				'default_value'  => array(
					'desktop' => array(
						'show_devices'   => true,
						'unit'           => 'px',
						'top'            => 0,
						'right'          => 0,
						'bottom'         => 0,
						'left'           => 0,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => '--brandy-footer-row-outside-margin',
							'value_path' => array( 'outside_margin' ),
						),
					),
				),
			),
			'height'                         => array(
				'title'          => array(
					'text'         => __( 'Min height', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'value_path'     => array( 'height' ),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => array(
						'min'   => 10,
						'max'   => 500,
						'unit'  => 'px',
						'value' => 70,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'hide_units'     => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--brandy-footer-height',
							'value_path' => array( 'height' ),
						),
					),
				),
			),
			'border_radius'                  => array(
				'value_path'     => array( 'border_radius' ),
				'title'          => array(
					'text'         => 'Border radius',
					'type'         => 'bold',
					'show_devices' => true,
				),
				'default_value'  => array(
					'desktop' => array(
						'show_devices'   => true,
						'unit'           => 'px',
						'top'            => 0,
						'right'          => 0,
						'bottom'         => 0,
						'left'           => 0,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'aspect_titles'  => array(
					'TLeft',
					'TRight',
					'BRight',
					'BLeft',
				),
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => '--brandy-footer-border-radius',
							'value_path' => array( 'border_radius' ),
						),
					),
				),
			),
		);
	}

	public function add_partial_refresh( $partials = array() ) {
		foreach ( brandy_get_devices() as $device ) {
			foreach ( array_keys( $this->rows ) as $row ) {
				$id         = $row . '_footer_' . $device;
				$partials[] = array(
					'configuration_type' => 'control',
					'id'                 => $id,
					'partial'            => array(
						'selector'            => '#brandy-footer [device=' . $device . '] #brandy-' . $row . '-footer',
						'render_callback'     => array( new RowBuilder( 'footer', $row, $device ), 'render' ),
						'container_inclusive' => true,
						'fallback_refresh'    => false,
					),
					'default'            => '',
					'transport'          => 'postMessage',
				);
			}
		}
		return $partials;
	}
}
