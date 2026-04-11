<?php

// Load the Elgg testing bootstrap
\Elgg\Application::loadAndBootCore();

// Ensure the menus_api plugin functions are loaded
$plugin_root = dirname(__DIR__);
require_once "{$plugin_root}/lib/functions.php";
