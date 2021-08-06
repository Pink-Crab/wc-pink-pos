<?php

/**
 * Sample Test
 *
 * @package PinkCrab\WC_Pink_Pos\Tests
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */

namespace PinkCrab\WC_Pink_Pos\Test\Unit\Webhook\Customer;

use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route;
use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Settings;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Factory;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Collection;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Repository;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App_Config;
use PinkCrab\WC_Pink_Pos\Webhook\Customer\Customer_Route_Controller;
use PinkCrab\WC_Pink_Pos\Webhook\Customer\Customer_Webhook_Subscriber;
use PinkCrab\WC_Pink_Pos\Webhook\Authentication\Webhook_Authentication;

class Test_Customer_Route_Controller extends \WP_UnitTestCase {

	/** @testdox The Webhook Customer route should be defined with all its namespaces, routes and auth checks. */
	public function test_define_routes(): void {

		$config = new App_Config(
			array(
				'additional' => array(
					// Webhook settings/keys
					'webhook' => (object) array(
						'route_namespace' => 'pinkcrab/wc-pink-pos/v1/webhook',
						'settings_prefix' => 'pc_pink_pos_webhook_',
					),
				),
			)
		);

		// Construct the controller and its dependencies.
		$webhook_settings = new Webhook_Settings( $config );
		$webhook_auth     = new Webhook_Authentication( $webhook_settings );
		$customer_factory = new Customer_Factory( new Customer_Repository( $config ) );
		$subscriber       = new Customer_Webhook_Subscriber( $customer_factory, new Customer_Repository( $config ) );
		$controller       = new Customer_Route_Controller( $config, $subscriber, $webhook_auth );

		// Get all defined routes from controller
		$routes = $controller->get_routes( new Route_Collection() );
		$this->assertCount( 1, $routes );

		// Get route.
		$route = $routes->pop();
		$this->assertInstanceOf( Route::class, $route );

		// Check properties
		$this->assertEquals( 'pinkcrab/wc-pink-pos/v1/webhook', $route->get_namespace() );
		$this->assertEquals( '/customer', $route->get_route() );
		$this->assertEquals( 'POST', $route->get_method() );

		// Check has valid auth callback.
		$auth      = $route->get_authentication();
		$reflected = new \ReflectionFunction( $auth[0] );
		$this->assertInstanceOf( Webhook_Authentication::class, $reflected->getClosureThis() );

	}
}
