<?php
/**
 * A single element of a menu.
 *
 * @package Elgg.Core
 * @subpackage Navigation
 *
 * @uses $vars['item']       ElggMenuItem
 * @uses $vars['item_class'] Additional CSS class for the menu item
 */
$item = elgg_extract('item', $vars);
if (!$item instanceof \ElggMenuItem) {
	return;
}

$item->addItemClass('elgg-menu-item');

$children = $item->getChildren();
if ($children) {
	$link_class = $item->getSelected() ? 'elgg-menu-opened' : 'elgg-menu-closed';
	$item->addLinkClass($link_class);
	$item->addLinkClass('elgg-menu-parent');
}

if ($item->getSelected()) {
	$item->addItemClass('elgg-state-selected');
}

$text = $item->getText();
if (!preg_match('~<[a-z]~', $text) && !$item->getHref()) {
	$text = elgg_format_element('span', ['class' => 'elgg-non-link'], $text);
}

$icon_view = '';
$icon = $item->getData('icon');
if ($icon) {
	$icon_view = elgg_view_icon($icon);
}

$indicator_view = '';
$indicator = $item->getData('indicator');
if (isset($indicator)) {
	$indicator_view = elgg_format_element('span', ['class' => 'elgg-menu-indicator'], (int) $indicator);
}

if ($item->getData('title')) {
	$item->addLinkClass('elgg-tooltip');
}

$item->setText($icon_view . $text . $indicator_view);

$item_view = elgg_view_menu_item($item);
if ($children) {
	$item_view .= elgg_view('navigation/menu/elements/section', [
		'items' => $children,
		'class' => 'elgg-menu elgg-child-menu',
	]);
}

echo elgg_format_element('li', [
	'class' => $item->getItemClass(),
	'data-menu-item' => $item->getName(),
		], $item_view);

$require = (array) $item->getData('require');
if (!empty($require)) {
	?>
	<script>
		require(<?= json_encode($require) ?>);
	</script>
	<?php
}