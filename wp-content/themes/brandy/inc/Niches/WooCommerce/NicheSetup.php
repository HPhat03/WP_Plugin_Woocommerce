<?php

namespace Brandy\Niches\WooCommerce;

use Brandy\Abstracts\AbstractNicheSetup;
use Brandy\Traits\SingletonTrait;

class NicheSetup extends AbstractNicheSetup {
	use SingletonTrait;

	public const NICHE_ID = 'woocommerce';

	public const ROOT_PATH = BRANDY_TEMPLATE_DIR . '/inc/Niches/WooCommerce';

	public const ROOT_URL = BRANDY_TEMPLATE_URL . '/inc/Niches/WooCommerce';

	protected const JSON_FILE = BRANDY_TEMPLATE_DIR . '/styles/woocommerce.json';

	protected const NICHE_NAME = 'WooCommerce store';

	protected const NICHE_THUMBNAIL = 'https://images.wpbrandy.com/uploads/wc-site-thumb-compress-img.webp';

	protected const NICHE_DEMO_URL = 'https://brandydemo.com/woo/';

	public static function get_sample_posts() {
		return array(
			'gutenberg' => static::ROOT_PATH . '/sample-data/sample-posts.json',
		);
	}

}
