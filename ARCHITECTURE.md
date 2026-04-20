# menus_api — Architecture (Elgg 5.x)

## Summary

menus_api provides a menus API for Elgg plugins. It registers custom views
for menu rendering (default menu, section, and item views) and provides
a CSS extension for navigation item styling.

## Directory Structure

```
menus_api/
├── classes/hypeJunction/MenusApi/
│   └── Bootstrap.php        — Plugin bootstrap (loads lib/functions.php)
├── lib/
│   └── functions.php        — Public API functions (menus_api_get_menu, etc.)
├── views/default/
│   └── navigation/menu/
│       ├── default.php      — Default menu renderer
│       └── elements/
│           ├── item.css     — Menu item styles
│           ├── item.php     — Menu item view (icon, indicator, tooltip support)
│           └── section.php  — Menu section view
├── tests/
│   ├── phpunit/integration/hypeJunction/MenusApi/
│   │   ├── FunctionsTest.php
│   │   └── ViewTest.php
│   ├── bootstrap.php
│   └── phpunit.xml
├── composer.json
└── elgg-plugin.php
```

## Public API

Functions loaded via `lib/functions.php` in `Bootstrap::boot()`:

| Function | Description |
|----------|-------------|
| `menus_api_get_menu($name, $params)` | Trigger `register` event, return menu items array |
| `menus_api_prepare_params($name, $params)` | Trigger `parameters` event, add default `sort_by` |
| `menus_api_prepare_menu($items, $params)` | Build via `ElggMenuBuilder`, trigger `prepare` event |
| `menus_api_view_menu($name, $params)` | Convenience: prepare + render `navigation/menu/default` |
| `menus_api_combine_menus($names, $params)` | Merge multiple menus into one item array |

## Events Triggered

All are named menu events (Elgg 5.x event system):

| Event | Type | Description |
|-------|------|-------------|
| `register` | `menu:{name}` | Register menu items; return value is `MenuItems` object |
| `parameters` | `menu:{name}` | Modify menu params; return value is params array |
| `prepare` | `menu:{name}` | Post-process built menu; return value is `PreparedMenu` |

## View Extensions

| Extends | With |
|---------|------|
| `elements/navigation.css` | `navigation/menu/elements/item.css` |

## Bootstrap

`hypeJunction\MenusApi\Bootstrap` — loaded via `'bootstrap'` key in
`elgg-plugin.php`. `boot()` method requires `lib/functions.php`.

## Dependencies

None — leaf plugin.

## Migration Notes (4.x → 5.x)

- Plugin hooks unified under the Elgg event API: all three `elgg_trigger_plugin_hook()` calls replaced with `elgg_trigger_event_results()`.
- Tests updated: `\Elgg\Hook` → `\Elgg\Event`, `elgg_register_plugin_hook_handler` → `elgg_register_event_handler`, `elgg_unregister_plugin_hook_handler` → `elgg_unregister_event_handler`.
- `elgg-plugin.php` `views.extensions` format fixed: nested array value changed to plain string (`'base' => 'extending_view'`).
- `views/navigation/menu/default.php`: added `PreparedMenu` detection — `ElggMenuBuilder::getMenu()` returns `PreparedMenu` in 5.x (not array); converted to section-keyed array before existing rendering logic.
- `views/navigation/menu/elements/item.php`: replaced removed `elgg_view_menu_item()` with `elgg_view('navigation/menu/elements/item/url', ['item' => $item])`.
- Docker infra: bumped to `php:8.2-apache`, `mysql:8.0`, `elgg/elgg ~5.1.0`, `phpunit ~9.6`.
- `composer.json`: `php >=7.4` → `>=8.2`, `elgg/elgg ^4.0` → `^5.0`.
