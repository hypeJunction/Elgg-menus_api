# menus_api — Architecture (Elgg 4.x)

## Summary

menus_api provides a menus API for Elgg plugins. It registers custom views
for menu rendering (default menu, section, and item views) and provides
a CSS extension for navigation item styling.

## Directory Structure

```
menus_api/
├── classes/hypeJunction/MenusApi/
│   └── Bootstrap.php        — Plugin bootstrap
├── lib/
│   └── functions.php        — Public API functions (menus_api_get_menu, etc.)
├── views/default/
│   └── navigation/menu/
│       ├── default.php      — Default menu renderer
│       └── elements/
│           ├── item.css     — Menu item styles
│           ├── item.php     — Menu item view
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

## View Extensions

| Extends | With |
|---------|------|
| `elements/navigation.css` | `navigation/menu/elements/item.css` |

## Bootstrap

`hypeJunction\MenusApi\Bootstrap` — loaded via `'bootstrap'` key in
`elgg-plugin.php`.

## Dependencies

None — leaf plugin.

## Migration Notes (3.x → 4.x)

- `manifest.xml` removed; `composer.json` is now the sole metadata source.
- `elgg-plugin.php` received the `'plugin'` key.
- `php` constraint added (`>=7.4`); `elgg/elgg` constraint added (`^4.0`);
  `composer/installers` bumped to `^2.0`; `config.allow-plugins` added.
- PHPUnit tests require `ELGG_SETTINGS_FILE` env var to use the installed DB.
- System cache must be cleared after plugin activation for PHPUnit to find
  views on first run.
