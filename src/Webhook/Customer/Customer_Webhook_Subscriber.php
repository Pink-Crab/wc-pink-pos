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

use WP_REST_Request;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Factory;
use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Subscriber;

class Customer_Webhook_Subscriber extends Webhook_Subscriber {

	/**
	 * @var Customer_Factory
	 */
	protected $customer_factory;

	public function __construct( Customer_Factory $customer_factory ) {
		$this->customer_factory = $customer_factory;
	}

	/**
	 * Returns the webhook type/domain
	 *
	 * @return string
	 */
	public function webhook_type(): string {
		return 'customer';
	}

	/**
	 * Validates the contents of webhook data.
	 *
	 * @param WP_REST_Request $request
	 * @return boolean
	 */
	protected function validate_webhook_data( WP_REST_Request $request ): bool {
		if ( ! $request->get_json_params() ) {
			return false;
		}

		$payload = $request->get_json_params();

		// Ensure is customer data.
		if ( ! \array_key_exists( 'type', $payload ) && 'customer' !== $payload['type'] ) {
			return false;
		}

		// Check is valid action.
		if ( ! \array_key_exists( 'type', $payload )
		&& ! in_array( $payload['action'], array( 'create', 'update', 'delete' ), true )
		) {
			return false;
		}
		return true;
	}

	/**
	 * Handles the request.
	 *
	 * @param WP_REST_Request $request
	 * @return array<string, mixed>
	 */
	public function handle_request( WP_REST_Request $request ): array {
		$payload = $request->get_json_params();

		$r = $this->customer_factory->from_pink_pos_webhook( $payload['data'] );
		$c = $this->customer_factory->create_user( $r );
		dump( $r, $request->get_json_params(), $c );
		return array(
			'a' => 1,
			'b' => 2,
			'c' => 3,
		);
	}
}
