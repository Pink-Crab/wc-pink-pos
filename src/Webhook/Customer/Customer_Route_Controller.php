<?php


declare(strict_types=1);

/**
 * Customer Webhook Controller
 *
 * @package PinkCrab/WC_Pink_Pos
 * @subpackage webhook
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Webhook\Customer;

use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Factory;
use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Subscriber;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App_Config;
use PinkCrab\WC_Pink_Pos\Webhook\Authentication\Webhook_Authentication;
use pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Controller;

class Customer_Route_Controller extends Route_Controller {

	/**
	 * Webhook Subscriber
	 *
	 * @var Webhook_Subscriber
	 */
	protected $webhook_subscriber;

	/**
	 * Webhook auth.
	 *
	 * @var Webhook_Authentication
	 */
	protected $webhook_authentication;

	public function __construct(
		App_Config $config,
		Webhook_Subscriber $webhook_subscriber,
		Webhook_Authentication $webhook_authentication
	) {
		$this->namespace              = $config->additional( 'webhook' )->route_namespace;
		$this->webhook_subscriber     = $webhook_subscriber;
		$this->webhook_authentication = $webhook_authentication;
	}

	/**
	 * Method defined to register all routes.
	 *
	 * @param Route_Factory $factory
	 * @return array<Route|Route_Group>
	 */
	protected function define_routes( Route_Factory $factory ) : array {
		return array(
			$factory->post( '/customer', $this->webhook_subscriber )
				->authentication( $this->webhook_authentication->validate_header_api_key() ),
		);
	}
}
