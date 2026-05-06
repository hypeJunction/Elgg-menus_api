<?php

namespace hypeJunction\MenusApi;

use Elgg\DefaultPluginBootstrap;

/**
 * Plugin bootstrap.
 */
class Bootstrap extends DefaultPluginBootstrap {

	/**
	 * {@inheritdoc}
	 */
	public function boot() {
		require_once dirname(__DIR__, 3) . '/lib/functions.php';
	}
}
