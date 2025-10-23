<?php

namespace Brandy\Admin;

use Brandy\Admin\Pages\Dashboard\ThemeDashboard;
use Brandy\Admin\PostEditor\PostEditorSetup;
use Brandy\Traits\SingletonTrait;

class AdminSetup {
	use SingletonTrait;

	protected function __construct() {
		ThemeDashboard::get_instance();
		PostEditorSetup::get_instance();
	}
}
