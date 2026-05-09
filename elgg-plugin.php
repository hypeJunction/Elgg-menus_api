<?php

return [
	'plugin' => [
		'id' => 'menus_api',
		'name' => 'Menus API',
		'version' => '2.0.0',
		'description' => 'Extends Elgg\'s menu system with a programmatic API for combining, filtering, and rendering navigation menus across plugins.',
		'author' => 'Ismayil Khayredinov',
		'category' => 'utility',
	],

	'bootstrap' => \hypeJunction\MenusApi\Bootstrap::class,
	'views' => [
		'extensions' => [
			'elements/navigation.css' => 'navigation/menu/elements/item.css',
		],
	],
];
