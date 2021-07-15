<?php

namespace pc_pink_pos_0_0_1;

/**
 * PHPUnit bootstrap file
 */
// Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available
require_once \dirname(__DIR__) . '/vendor/autoload.php';
// Give access to tests_add_filter() function.
require_once \getenv('WP_PHPUNIT__DIR') . '/includes/functions.php';
\pc_pink_pos_0_0_1\tests_add_filter('muplugins_loaded', function () {
});
// Start up the WP testing environment.
require \getenv('WP_PHPUNIT__DIR') . '/includes/bootstrap.php';
