# Menus API

![Elgg 7.x](https://img.shields.io/badge/Elgg-7.x-orange.svg?style=flat-square)

Extends Elgg's menu system with a programmatic API for combining, filtering, and rendering navigation menus across plugins.

## Features

- Combine multiple Elgg menus into a single item list (`menus_api_combine_menus()`)
- Retrieve and filter menu items with prepared parameters (`menus_api_get_menu()`)
- Render menus scoped to specific sections with custom sort order (`menus_api_view_menu()`)
- Decorate menu items with icons and badge indicators via `data-icon` / `data-indicator`
- Break child menus into ordered subsections

## Installation

**Via Composer (recommended):**

```bash
composer require hypejunction/menus_api
```

**Manual:**

Download the zip, extract into your Elgg `mod/` directory, and activate in the admin panel.

## License

GPL-2.0

## Compatibility

| Plugin version | Elgg version |
|---|---|
| current | 7.x |
