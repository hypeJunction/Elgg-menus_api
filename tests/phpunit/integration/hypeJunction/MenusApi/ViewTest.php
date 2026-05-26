<?php

namespace hypeJunction\MenusApi;

use Elgg\IntegrationTestCase;
use ElggMenuItem;

class ViewTest extends IntegrationTestCase {

	/**
	 * Override to prevent auto-skip when plugin isn't active in test DB.
	 */
	public function getPluginID(): string {
		return '';
	}

	public function up() {
		$libFile = dirname(__DIR__, 5) . '/lib/functions.php';
		if (!function_exists('menus_api_get_menu')) {
			require_once $libFile;
		}
	}

	public function down() {}

	public function testDefaultMenuViewRenders() {
		$items = [
			\ElggMenuItem::factory([
				'name' => 'test_link',
				'text' => 'Test Link',
				'href' => '#test',
			]),
		];

		$builder = new \ElggMenuBuilder($items);
		$menu = $builder->getMenu('priority');

		$output = \elgg_view('navigation/menu/default', [
			'name' => 'phpunit_test',
			'menu' => $menu,
		]);

		$this->assertIsString($output);
		$this->assertNotEmpty($output);
		$this->assertStringContainsString('elgg-menu', $output);
		$this->assertStringContainsString('elgg-menu-phpunit-test', $output);
	}

	public function testSectionViewRenders() {
		$items = [
			\ElggMenuItem::factory([
				'name' => 'section_item',
				'text' => 'Section Item',
				'href' => '#section',
			]),
		];

		$output = \elgg_view('navigation/menu/elements/section', [
			'items' => $items,
			'class' => ['elgg-menu', 'elgg-menu-test'],
			'section' => 'default',
			'name' => 'test_section',
		]);

		$this->assertIsString($output);
		$this->assertNotEmpty($output);
		$this->assertStringContainsString('<ul', $output);
	}

	public function testItemViewRenders() {
		$item = \ElggMenuItem::factory([
			'name' => 'rendered_item',
			'text' => 'Rendered Item',
			'href' => '#rendered',
		]);

		$output = \elgg_view('navigation/menu/elements/item', [
			'item' => $item,
		]);

		$this->assertIsString($output);
		$this->assertNotEmpty($output);
		$this->assertStringContainsString('rendered_item', $output);
		$this->assertStringContainsString('Rendered Item', $output);
	}

	public function testItemWithChildrenRendersDropdown() {
		$child = \ElggMenuItem::factory([
			'name' => 'child_item',
			'text' => 'Child Item',
			'href' => '#child',
		]);

		$parent = \ElggMenuItem::factory([
			'name' => 'parent_item',
			'text' => 'Parent Item',
			'href' => '#parent',
		]);
		$parent->setChildren([$child]);

		$output = \elgg_view('navigation/menu/elements/item', [
			'item' => $parent,
		]);

		$this->assertIsString($output);
		$this->assertNotEmpty($output);
		$this->assertStringContainsString('parent_item', $output);
		$this->assertStringContainsString('child_item', $output);
		$this->assertStringContainsString('elgg-child-menu', $output);
		$this->assertStringContainsString('elgg-menu-parent', $output);
	}

	public function testItemRendersCorrectly() {
		$item = \ElggMenuItem::factory([
			'name' => 'basic_item',
			'text' => 'Basic Item',
			'href' => '#basic',
		]);

		$output = \elgg_view('navigation/menu/elements/item', [
			'item' => $item,
		]);

		$this->assertIsString($output);
		$this->assertNotEmpty($output);
		$this->assertStringContainsString('basic_item', $output);
		$this->assertStringContainsString('Basic Item', $output);
		$this->assertStringContainsString('#basic', $output);
	}
}
