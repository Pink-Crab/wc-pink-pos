<?php

namespace pinkcrab_cccp_0_0_1;

/**
 * PHPUnit bootstrap file
 */
// Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available
require_once \dirname(__DIR__) . '/vendor/autoload.php';
// Give access to tests_add_filter() function.
require_once \getenv('WP_PHPUNIT__DIR') . '/includes/functions.php';
$wp_install_path = \dirname(__FILE__, 2) . '/wordpress';
\define('TEST_WP_ROOT', $wp_install_path);
\pinkcrab_cccp_0_0_1\tests_add_filter('muplugins_loaded', function () {
});
// Start up the WP testing environment.
require \getenv('WP_PHPUNIT__DIR') . '/includes/bootstrap.php';
