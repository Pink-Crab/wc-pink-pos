<?php

/**
 * @wordpress-plugin
 * Plugin Name:     CCCP WooCommerce Bridge
 * Plugin URI:      https://github.com/pink-crab/cccp-wc-bridge
 * Description:     A bridge between WooCommerce and the PinkCrab CCCP Project.
 * Version:         0.0.1
 * Author:          Glynn Quelch
 * Author URI:      https://github.com/gin0115
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     pc_cccp
 */

use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App_Factory;

require_once __DIR__ . '/function_pollyfills.php';
require_once __DIR__ . '/build/vendor/autoload.php';

( new App_Factory() )->with_wp_dice( true )
	->di_rules( require __DIR__ . '/config/dependencies.php' )
	->app_config( require __DIR__ . '/config/settings.php' )
	->registration_classes( require __DIR__ . '/config/registration.php' )
	->boot();
