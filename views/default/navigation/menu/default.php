<?php

/**
 * Default menu
 *
 * @uses $vars['name']                 Name of the menu
 * @uses $vars['menu']                 Array of menu items
 * @uses $vars['class']                Additional CSS class for the menu
 * @uses $vars['item_class']           Additional CSS class for each menu item
 * @uses $vars['show_section_headers'] Do we show headers for each section?
 * @uses $vars['sections']             An array of sections to display. Sections will be dipslayed in the same order as in this array
 */
// we want css classes to use dashes
$name = elgg_extract('name', $vars);

if (elgg_view_exists("navigation/menu/$name")) {
	echo elgg_view("navigation/menu/$name", $vars);
	return;
}

$name_selector = preg_replace('/[^a-z0-9\-]/i', '-', $name);

$menu = elgg_extract('menu', $vars);
unset($vars['menu']);

$ordered_menu = [];

// allow plugins to specify which sections to show and in which order
$display_sections = (array) elgg_extract('sections', $vars, []);

if (empty($display_sections)) {
	$display_sections = array_keys($menu);
}

$menu_sections = array_keys($menu);
foreach ($menu_sections as $section) {
	if (!in_array($section, $display_sections)) {
		continue;
	}
	$ordered_menu[$section] = $menu[$section];
}

$class = (array) elgg_extract('class', $vars, []);
$class[] = 'elgg-menu';
$class[] = "elgg-menu-$name_selector";

foreach ($ordered_menu as $section => $menu_items) {
	$section_class = $class;
	$section_class[] = "elgg-menu-$name_selector-$section";
	$section_params = [
		'items' => $menu_items,
		'class' => $section_class,
		'section' => $section,
		'name' => $name,
	];

	echo elgg_view('navigation/menu/elements/section', array_merge($vars, $section_params));
}
