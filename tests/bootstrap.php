<?php

use Gin0115\WPUnit_Helpers\WP\WP_Dependencies;

/**
 * PHPUnit bootstrap file
 */


// Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available
require_once dirname( __DIR__ ) . '/build/vendor/autoload.php';

// Give access to tests_add_filter() function.
require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

// Fixtures base path.
define( 'PC_TESTS_FIXTURES', __DIR__ . '/Fixtures' );
$wp_install_path = dirname( __FILE__, 2 ) . '/wordpress';
define( 'TEST_WP_ROOT', $wp_install_path );


tests_add_filter(
	'muplugins_loaded',
	function() {
		require_once dirname( __DIR__, 1 ) . '/plugin.php';

		try {
			// This needs to be run once!
			if ( ! file_exists( TEST_WP_ROOT . '/wp-content/plugins/woocommerce/woocommerce.php' ) ) {
				WP_Dependencies::install_remote_plugin_from_zip(
					'https://github.com/woocommerce/woocommerce/releases/download/nightly/woocommerce-trunk-nightly.zip',
					TEST_WP_ROOT
				);
			}
		} catch ( \Throwable $th ) {
			print 'Failed to install plugin';
			print $th->getMessage();
			print 'Cancelling setup';
			exit;
		}

		WP_Dependencies::activate_plugin( '/woocommerce/woocommerce.php' );

		// RUN WC Installer.
		// Always load PayPal Standard for unit tests.
		tests_add_filter( 'woocommerce_should_load_paypal_standard', '__return_true' );

		// load WC.
		tests_add_filter(
			'muplugins_loaded',
			function () {
				define( 'WC_TAX_ROUNDING_MODE', 'auto' );
				define( 'WC_USE_TRANSACTIONS', false );
				require_once TEST_WP_ROOT . '/wp-content/plugins/woocommerce/woocommerce.php';
			}
		);

		// install WC.
		tests_add_filter(
			'setup_theme',
			function () {

				// Clean existing install first.
				define( 'WP_UNINSTALL_PLUGIN', true );
				define( 'WC_REMOVE_ALL_DATA', true );
				include TEST_WP_ROOT . '/wp-content/plugins/woocommerce/uninstall.php';

				// Initialize the WC API extensions.
				\Automattic\WooCommerce\Admin\Install::create_tables();
				\Automattic\WooCommerce\Admin\Install::create_events();

				WC_Install::install();

				// Reload capabilities after install, see https://core.trac.wordpress.org/ticket/28374.
				if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
					$GLOBALS['wp_roles']->reinit();
				} else {
					$GLOBALS['wp_roles'] = null; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					wp_roles();
				}

				echo esc_html( 'Installing WooCommerce...' . PHP_EOL );
			}
		);

	}
);

	// Start up the WP testing environment.
	require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';
