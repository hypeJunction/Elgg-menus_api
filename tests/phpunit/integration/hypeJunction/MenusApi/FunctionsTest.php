<?php

namespace hypeJunction\MenusApi;

use Elgg\IntegrationTestCase;
use ElggMenuItem;

class FunctionsTest extends IntegrationTestCase {

	/**
	 * Override to prevent auto-skip when plugin isn't active in test DB.
	 */
	public function getPluginID(): string {
		return '';
	}

	public function up() {
		// Ensure lib functions are loaded
		$libFile = dirname(__DIR__, 5) . '/lib/functions.php';
		if (!function_exists('menus_api_get_menu')) {
			require_once $libFile;
		}
	}

	public function down() {}

	public function testPrepareParamsDefaultSortBy() {
		$result = menus_api_prepare_params('test_default_sort', []);

		$this->assertIsArray($result);
		$this->assertEquals('priority', $result['sort_by']);
		$this->assertEquals('test_default_sort', $result['name']);
	}

	public function testPrepareParamsPreservesCustomSortBy() {
		$result = menus_api_prepare_params('test_custom_sort', [
			'sort_by' => 'text',
		]);

		$this->assertIsArray($result);
		$this->assertEquals('text', $result['sort_by']);
	}

	public function testPrepareParamsTriggersHook() {
		$hook_called = false;

		$handler = function (\Elgg\Hook $hook) use (&$hook_called) {
			$hook_called = true;
			return $hook->getValue();
		};

		\elgg_register_plugin_hook_handler('parameters', 'menu:test_params_hook', $handler);

		menus_api_prepare_params('test_params_hook', []);

		$this->assertTrue($hook_called, 'The parameters:menu:test_params_hook hook should have been triggered');

		\elgg_unregister_plugin_hook_handler('parameters', 'menu:test_params_hook', $handler);
	}

	public function testGetMenuTriggersRegisterHook() {
		$handler = function (\Elgg\Hook $hook) {
			$value = $hook->getValue();
			$value[] = \ElggMenuItem::factory([
				'name' => 'hook_item',
				'text' => 'Hook Item',
				'href' => '#hook-item',
			]);
			return $value;
		};

		\elgg_register_plugin_hook_handler('register', 'menu:test_register_hook', $handler);

		$result = menus_api_get_menu('test_register_hook', []);

		$this->assertNotEmpty($result, 'Menu should contain items added via hook');

		$found = false;
		foreach ($result as $item) {
			if ($item instanceof \ElggMenuItem && $item->getName() === 'hook_item') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found, 'Menu should contain the item added by the register hook');

		\elgg_unregister_plugin_hook_handler('register', 'menu:test_register_hook', $handler);
	}

	public function testGetMenuReturnsMenuItems() {
		$result = menus_api_get_menu('test_empty_menu', []);

		$this->assertIsArray($result);
	}

	public function testPrepareMenuTriggersHook() {
		$hook_called = false;

		$handler = function (\Elgg\Hook $hook) use (&$hook_called) {
			$hook_called = true;
			return $hook->getValue();
		};

		\elgg_register_plugin_hook_handler('prepare', 'menu:test_prepare_hook', $handler);

		$items = [
			\ElggMenuItem::factory([
				'name' => 'prepare_item',
				'text' => 'Prepare Item',
				'href' => '#prepare',
			]),
		];

		menus_api_prepare_menu($items, ['name' => 'test_prepare_hook']);

		$this->assertTrue($hook_called, 'The prepare:menu:test_prepare_hook hook should have been triggered');

		\elgg_unregister_plugin_hook_handler('prepare', 'menu:test_prepare_hook', $handler);
	}

	public function testViewMenuReturnsHtml() {
		$handler = function (\Elgg\Hook $hook) {
			$value = $hook->getValue();
			$value[] = \ElggMenuItem::factory([
				'name' => 'view_test_item',
				'text' => 'View Test Item',
				'href' => '#view-test',
			]);
			return $value;
		};

		\elgg_register_plugin_hook_handler('register', 'menu:test_view_menu', $handler);

		$result = menus_api_view_menu('test_view_menu', []);

		$this->assertIsString($result);
		$this->assertNotEmpty($result);

		\elgg_unregister_plugin_hook_handler('register', 'menu:test_view_menu', $handler);
	}

	public function testCombineMenusMergesItems() {
		$handler_a = function (\Elgg\Hook $hook) {
			$value = $hook->getValue();
			$value[] = \ElggMenuItem::factory([
				'name' => 'item_a',
				'text' => 'Item A',
				'href' => '#a',
				'section' => 'custom_section',
			]);
			return $value;
		};

		$handler_b = function (\Elgg\Hook $hook) {
			$value = $hook->getValue();
			$value[] = \ElggMenuItem::factory([
				'name' => 'item_b',
				'text' => 'Item B',
				'href' => '#b',
				'section' => 'custom_section',
			]);
			return $value;
		};

		\elgg_register_plugin_hook_handler('register', 'menu:menu_a', $handler_a);
		\elgg_register_plugin_hook_handler('register', 'menu:menu_b', $handler_b);

		$result = menus_api_combine_menus(['menu_a', 'menu_b'], []);

		$this->assertCount(2, $result);

		$names = array_map(function ($item) {
			return $item->getName();
		}, $result);

		$this->assertContains('item_a', $names);
		$this->assertContains('item_b', $names);

		\elgg_unregister_plugin_hook_handler('register', 'menu:menu_a', $handler_a);
		\elgg_unregister_plugin_hook_handler('register', 'menu:menu_b', $handler_b);
	}

	public function testCombineMenusRenamesSections() {
		$handler = function (\Elgg\Hook $hook) {
			$value = $hook->getValue();
			// ElggMenuItem defaults to 'default' section when none specified
			$value[] = \ElggMenuItem::factory([
				'name' => 'default_section_item',
				'text' => 'Default Section Item',
				'href' => '#default',
			]);
			return $value;
		};

		\elgg_register_plugin_hook_handler('register', 'menu:rename_test_menu', $handler);

		$result = menus_api_combine_menus(['rename_test_menu'], []);

		$this->assertNotEmpty($result);

		$item = $result[0];
		$this->assertInstanceOf(\ElggMenuItem::class, $item);
		$this->assertEquals('rename_test_menu', $item->getSection(),
			'Items with "default" section should be renamed to the menu name');
		$this->assertEquals('rename_test_menu', $item->getData('menu_name'),
			'Each item should have menu_name data set');

		\elgg_unregister_plugin_hook_handler('register', 'menu:rename_test_menu', $handler);
	}
}
