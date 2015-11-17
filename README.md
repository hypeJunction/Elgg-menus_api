Menus API
=========
![Elgg 2.0](https://img.shields.io/badge/Elgg-2.0.x-orange.svg?style=flat-square)

Various convenient functions and views for working with menus

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


## Note

 * This plugin replaces the default menu, section and item views