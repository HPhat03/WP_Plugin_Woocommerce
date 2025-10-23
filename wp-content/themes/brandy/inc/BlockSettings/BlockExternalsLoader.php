<?php

namespace Brandy\BlockSettings;

use Brandy\Traits\SingletonTrait;

class BlockExternalsLoader {
	use SingletonTrait;

	protected function __construct() {
		require_once __DIR__ . '/FeaturedImagePlaceholder/Caller.php';
		require_once __DIR__ . '/AvatarPostAuthorTooltip/Caller.php';
		require_once __DIR__ . '/ContentResponsiveControls/Caller.php';
	}
}

BlockExternalsLoader::get_instance();
