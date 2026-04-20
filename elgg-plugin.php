<?php

return [
	'plugin' => [
		'id' => 'menus_api',
		'name' => 'Menus API',
		'version' => '2.0.0',
		'description' => 'Menus API for Elgg plugins.',
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
