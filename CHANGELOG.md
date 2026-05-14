<a name="7.0.0"></a>
## 7.0.0 (2026-05-09) — Elgg 7.x migration

### Breaking Changes

* **elgg:** raise minimum to Elgg 7.x (PHP 8.3+).

### Migration (6.x → 7.x)

* **composer:** `elgg/elgg ~7.0.0`, PHP `>=8.3`.
* **docker:** test stack added for Elgg 7.x (docker/elgg7/).
* No PHP or CSS breaking changes. No data migration required.

<a name="6.0.0"></a>
## 6.0.0 (2026-05-09) — Elgg 6.x migration

### Breaking Changes

* **elgg:** raise minimum to Elgg 6.x (PHP 8.1+).

### Migration (5.x → 6.x)

* **composer:** `elgg/elgg ~6.1.0`, PHP `>=8.1`, added `ext-intl`.
* **elgg-plugin.php:** `views.extensions` converted to root-level `view_extensions` with nested array format.
* **docker:** test stack added for Elgg 6.x (docker/elgg6/).
* No data migration required.

<a name="2.0.0"></a>
## [2.0.0] — 2026-04-20 (Elgg 5.x migration)

### Breaking Changes

- Requires Elgg 5.x (`^5.0`) and PHP 8.2+.
- Menu events now use the unified Elgg event API: handlers must type-hint `\Elgg\Event` instead of `\Elgg\Hook` and must be registered with `elgg_register_event_handler()` instead of `elgg_register_plugin_hook_handler()`.

### Internal Changes

- All `elgg_trigger_plugin_hook()` calls replaced with `elgg_trigger_event_results()`.
- `elgg-plugin.php` `views.extensions` corrected to use the `'base' => 'extension'` string format.
- `views/navigation/menu/default.php` updated to handle `Elgg\Menu\PreparedMenu` objects returned by `ElggMenuBuilder` in Elgg 5.x.
- `views/navigation/menu/elements/item.php` updated: removed `elgg_view_menu_item()` (deleted in 5.x), replaced with `elgg_view('navigation/menu/elements/item/url', ...)`.

<a name="1.1.1"></a>
## [1.1.1](https://github.com/hypeJunction/Elgg-menus_api/compare/1.1.0...v1.1.1) (2016-02-10)


### Bug Fixes

* **css:** add missing style for menu indicator ([cf9d930](https://github.com/hypeJunction/Elgg-menus_api/commit/cf9d930))



<a name="1.1.0"></a>
# [1.1.0](https://github.com/hypeJunction/Elgg-menus_api/compare/1.0.3...v1.1.0) (2016-01-27)


### Features

* **dropdown:** move dropdown into its own plugin ([d060f58](https://github.com/hypeJunction/Elgg-menus_api/commit/d060f58))



<a name="1.0.3"></a>
## [1.0.3](https://github.com/hypeJunction/Elgg-menus_api/compare/1.0.2...v1.0.3) (2016-01-26)


### Bug Fixes

* **css:** do not show separators in a single dropdown menu ([a665939](https://github.com/hypeJunction/Elgg-menus_api/commit/a665939))



<a name="1.0.2"></a>
## 1.0.2 (2016-01-21)


### Features

* **menus:** add dropdown menus and subsections ([c9988b9](https://github.com/hypeJunction/Elgg-menus_api/commit/c9988b9))
* **releases:** initial commit ([ac115bb](https://github.com/hypeJunction/Elgg-menus_api/commit/ac115bb))



<a name="1.0.1"></a>
## 1.0.1 (2016-01-21)


### Features

* **menus:** add dropdown menus and subsections ([c9988b9](https://github.com/hypeJunction/Elgg-menus_api/commit/c9988b9))
* **releases:** initial commit ([ac115bb](https://github.com/hypeJunction/Elgg-menus_api/commit/ac115bb))



