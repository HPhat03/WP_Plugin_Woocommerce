<?php

namespace Brandy\Admin\PostEditor;

use Brandy\Admin\PostEditor\MetaServices\FooterTemplateMetaService;
use Brandy\Admin\PostEditor\MetaServices\HeaderBlurBackgroundMetaService;
use Brandy\Admin\PostEditor\MetaServices\HeaderTemplateMetaService;
use Brandy\Admin\PostEditor\MetaServices\HeaderTransparentMetaService;
use Brandy\Traits\SingletonTrait;

class PostMetaServices {
	use SingletonTrait;

	public $services = array();

	protected function __construct() {
		$this->register_service( 'header_transparent', HeaderTransparentMetaService::get_instance() );
		$this->register_service( 'header_template', HeaderTemplateMetaService::get_instance() );
		$this->register_service( 'footer_template', FooterTemplateMetaService::get_instance() );
		$this->register_service( 'header_blur_background', HeaderBlurBackgroundMetaService::get_instance() );
	}

	public function register_metae() {
		foreach ( $this->services as $service ) {
			$service->register_meta();
		}
	}

	private function register_service( $name, $service ) {
		$this->services[ $name ] = $service;
	}

	public static function map_array_to_css( $arr ) {
		return implode(
			';',
			array_map(
				function( $value, $name ) {
					return "$name:$value";
				},
				$arr,
				array_keys( $arr )
			)
		);
	}
}
