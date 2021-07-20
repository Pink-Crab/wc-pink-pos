<?php

/**
 * PHPUnit bootstrap file
 */


// Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available
require_once dirname( __DIR__ ) . '/build/vendor/autoload.php';

// Give access to tests_add_filter() function.
require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

// Fixtures base path.
define( 'PC_TESTS_FIXTURES', __DIR__ . '/Fixtures' );

tests_add_filter(
	'muplugins_loaded',
	function() {
		require_once dirname( __DIR__, 1 ) . '/plugin.php';
	}
);

// Start up the WP testing environment.
require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';
