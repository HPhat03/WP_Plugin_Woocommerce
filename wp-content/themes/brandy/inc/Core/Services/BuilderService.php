<?php

namespace Brandy\Core\Services;

class BuilderService {
	public static function get_settings_layouts() {
		return apply_filters( 'brandy_settings_layouts', array() );
	}
	public static function get_all_registered_settings() {
		return apply_filters( 'brandy_all_registered_settings', array() );
	}
}
