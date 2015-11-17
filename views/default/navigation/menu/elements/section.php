<?php

/**
 * Menu group
 *
 * @uses $vars['items']                Array of menu items
 * @uses $vars['class']                Additional CSS class for the section
 * @uses $vars['name']                 Name of the menu
 * @uses $vars['section']              The section name
 * @uses $vars['item_class']           Additional CSS class for each menu item
 * @uses $vars['show_section_headers'] Do we show headers for each section
 */
$items = (array) elgg_extract('items', $vars, []);
if (empty($items)) {
	return;
}

$class = elgg_extract('class', $vars, '');
$item_class = elgg_extract('item_class', $vars, '');

$name = elgg_extract('name', $vars);
$section = elgg_extract('section', $vars);

$list_items = '';
foreach ($items as $menu_item) {
	$list_items .= elgg_view('navigation/menu/elements/item', [
		'item' => $menu_item,
		'item_class' => $item_class,
	]);
}

$menu = elgg_format_element('ul', [
	'class' => $class,
	'data-menu' => $name,
	'data-section' => $section,
		], $list_items);

if (elgg_extract('show_section_headers', $vars, false)) {
	$name = preg_replace('/[^a-z0-9\-]/i', '-', $name);
	echo elgg_view_module('menu', elgg_echo("menu:$name:header:$section"), $menu);
} else {
	echo $menu;
}
