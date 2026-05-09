<?php

/**
 * Menus API
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2015, Ismayil Khayredinov
 */
require_once __DIR__ . '/autoloader.php';

elgg_register_event_handler('init', 'system', 'menus_api_init');

/**
 * Initialize
 * @return void
 */
function menus_api_init() {
	elgg_extend_view('elements/navigation.css', 'navigation/menu/elements/item.css');
}

/**
 * Get all menu items in a given menu
 *
 * @param string $menu_name Menu name
 * @param array  $params    Filtered menu params
 * @return ElggMenuItem[]
 */
function menus_api_get_menu($menu_name, array $params = []) {
	$menus = elgg_get_config('menus');
	$menu = (array) elgg_extract($menu_name, $menus, []);
	return elgg_trigger_plugin_hook('register', "menu:$menu_name", $params, $menu);
}

/**
 * Prepare menu parameters
 *
 * @param string $menu_name Menu name
 * @param array  $params    Filtered menu params
 * @return array
 */
function menus_api_prepare_params($menu_name, array $params = []) {
	$params['name'] = $menu_name;
	$params = elgg_trigger_plugin_hook('parameters', "menu:$menu_name", $params, $params);
	if (!isset($params['sort_by'])) {
		$params['sort_by'] = 'priority';
	}
	return $params;
}

/**
 * Prepare menu
 * Returns an array of section => items pairs
 *
 * @param ElggMenuItem[] $menu   Menu
 * @param array          $params Menu params
 * @return array
 */
function menus_api_prepare_menu($menu, array $params = []) {

	$menu_name = elgg_extract('name', $params);
	$sort_by = elgg_extract('sort_by', $params, 'text');

	$builder = new \ElggMenuBuilder($menu);
	$params['menu'] = $builder->getMenu($sort_by);
	$params['selected_item'] = $builder->getSelected();

	return elgg_trigger_plugin_hook('prepare', "menu:$menu_name", $params, $params['menu']);
}

/**
 *
 * @param type $menu_name
 * @param array $params
 */
function menus_api_view_menu($menu_name, array $params = []) {

	$params = menus_api_prepare_params($menu_name, $params);
	$menu = menus_api_get_menu($menu_name, $params);
	$params['menu'] = menus_api_prepare_menu($menu, $params);

	return elgg_view('navigation/menu/default', $params);
}

/**
 * Combine several menus into one
 * Menu items will be reassigned to a section named after the menu they belong to
 *
 * @param array $menu_names An array of menu name
 * @param array $params     Menu params
 * @return ElggMenuItem[]
 */
function menus_api_combine_menus(array $menu_names = [], array $params = []) {

	$return = [];
	foreach ($menu_names as $menu_name) {
		$params = menus_api_prepare_params($menu_name, $params);
		$items = menus_api_get_menu($menu_name, $params);
		if (!is_array($items) || empty($items)) {
			continue;
		}
		foreach ($items as $item) {
			if (!$item instanceof ElggMenuItem) {
				continue;
			}
			$section = $item->getSection();
			if ($section == 'default') {
				$item->setSection($menu_name);
			}
			$item->setData('menu_name', $menu_name);
			$return[] = $item;
		}
	}

	return $return;
}
