Menus API
=========
![Elgg 2.0](https://img.shields.io/badge/Elgg-2.0.x-orange.svg?style=flat-square)

Various convenient functions and views for working with menus

![Title Menu](https://raw.github.com/hypeJunction/Elgg-menus_api/master/screenshots/title.png "Sample Title Menu")

## Usage

### Combine menus

```php
$menu_items = menus_api_combine_menus([
    'entity',
    'owner_block',
    'user_hover'
], [
    'entity' => $user,
]);
```

### Get menu items

```php
$params = menus_api_prepare_params('user_hover', ['entity' => 'user]);
$items = menus_api_get_menu('user_hover', $params);
```

### Add icon and indicator

```php
$item = ElggMenuItem::factory([
    'name' => 'messages',
    'text' => 'New messages',
    'href' => '/messages',
    'data' => [
        'indicator' => 5,
        'icon' => 'envelope',
        'require' => ['js/menu/module'],
    ]
]);
```

### Only show certain menu sections

```php
echo menus_api_view_menu('user_hover', [
    'entity' => $user,
    'sections' => ['admin', 'action'],
    'sort_by' => 'priority',
]);
```

### Dropdown Menus

To convert child menus to dropdown menus, simply add `elgg-menu-dropdown` class to your
menu. Whenever a parent menu item is clicked, child menu will appear in a hover menu
(that will inherit classes from	`elgg-hover-menu`

```php
echo elgg_view_menu('entity', [
	'entity' => $user,
	'class' => 'elgg-menu-hz elgg-menu-dropdown',
]);
```

### Child menu subsections

You can break down child menus into subsections, and list them in a predefined order.

```php
$parent = ElggMenuItem::factory([
	'name' => 'parent',
	'text' => 'Parent',
	'data' => [
		'subsections' => ['actions', 'admin']
	]
]);


$item = ElggMenuItem::factory([
	'name' => 'action',
	'parent_name' => 'parent',
	'text' => 'Action',
	'data' => [
		'subsection' => 'actions'
	]
]);
```


## Note

 * This plugin replaces the default menu, section and item views