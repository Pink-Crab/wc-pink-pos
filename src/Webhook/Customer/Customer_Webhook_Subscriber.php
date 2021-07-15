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
use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Subscriber;

class Customer_Webhook_Subscriber extends Webhook_Subscriber {

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
		dump( $request );
		return false;
	}

	/**
	 * Handles the request.
	 *
	 * @param WP_REST_Request $request
	 * @return array<string, mixed>
	 */
	public function handle_request( WP_REST_Request $request ): array {

	}
}
