<?php

use Elgg\Menu\MenuSection;
use Elgg\Menu\PreparedMenu;

$name = elgg_extract('name', $vars);

if (elgg_view_exists("navigation/menu/$name")) {
	echo elgg_view("navigation/menu/$name", $vars);
	return;
}

$menu = elgg_extract('menu', $vars);
if (!$menu instanceof PreparedMenu) {
	return;
}

$name_selector = preg_replace('/[^a-z0-9\-]/i', '-', $name);

$display_sections = (array) elgg_extract('sections', $vars, []);

$class = (array) elgg_extract('class', $vars, []);
$class[] = 'elgg-menu';
$class[] = "elgg-menu-$name_selector";

foreach ($menu as $section) {
	if (!$section instanceof MenuSection) {
		continue;
	}

	$section_id = $section->getID();

	if (!empty($display_sections) && !in_array($section_id, $display_sections)) {
		continue;
	}

	$section_class = $class;
	$section_class[] = "elgg-menu-$name_selector-$section_id";

	echo elgg_view('navigation/menu/elements/section', [
		'items' => $section->all(),
		'class' => $section_class,
		'section' => $section_id,
		'name' => $name,
	]);
}
