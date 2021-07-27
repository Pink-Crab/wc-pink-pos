<?php


declare(strict_types=1);

/**
 * Customer Webhook Controller.
 *
 * @package PinkCrab/WC_Pink_Pos
 * @subpackage webhook
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Webhook\Customer;

use WP_REST_Request;
use PinkCrab\WC_Pink_Pos\Customer\Customer;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Factory;
use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Exception;
use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Subscriber;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Repository;

class Customer_Webhook_Subscriber extends Webhook_Subscriber {

	/**
	 * @var Customer_Factory
	 */
	protected $customer_factory;

	/**
	 * @var Customer_Repository
	 */
	protected $customer_repository;

	public function __construct( Customer_Factory $customer_factory, Customer_Repository $customer_repository ) {
		$this->customer_factory    = $customer_factory;
		$this->customer_repository = $customer_repository;
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
		if ( ! \array_key_exists( 'type', $payload ) && $this->webhook_type() !== $payload['type'] ) {
			return false;
		}

		// Check is valid action.
		if ( ! \array_key_exists( 'type', $payload )
		&& ! in_array( $payload['action'], array( parent::CREATE, parent::UPDATE, parent::DELETE ), true )
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
	 * @throws Webhook_Exception
	 */
	public function handle_request( WP_REST_Request $request ): array {
		$payload = $request->get_json_params();

		$customer = $this->customer_factory->from_pink_pos_webhook( $payload['data'] );
		if ( is_null( $customer ) ) {
			throw Webhook_Exception::invalid_payload( sanitize_text_field( $payload['action'] ), $this->webhook_type(), $payload );
		}

		switch ( $payload['action'] ) {
			case parent::CREATE:
				return array(
					parent::CREATE => $this->create_user( $customer ),
				);

			case parent::UPDATE:
				return array(
					parent::UPDATE => $this->update_user( $customer ),
				);

			default:
				throw Webhook_Exception::invalid_action( $payload['action'], $this->webhook_type(), $payload );
		}
	}

	/**
	 * Creates a user if it doesn't exist.
	 * Does nothing if it does.
	 *
	 * @param \PinkCrab\WC_Pink_Pos\Customer\Customer $customer
	 * @return int|null
	 * @throws Webhook_Exception
	 */
	protected function create_user( Customer $customer ): ?int {
		// Check if already exists.
		if ( ! is_null( $this->customer_repository->find_by_customer_id( $customer->get_customer_id() ) ) ) {
			throw Webhook_Exception::entity_exists( Webhook_Subscriber::CREATE, $this->webhook_type(), $customer );
		}

		return $this->customer_repository->create( $customer );
	}

	/**
	 * Updates a user if it exists.
	 * Does nothing if it doesn't.
	 *
	 * @param \PinkCrab\WC_Pink_Pos\Customer\Customer $customer
	 * @return int|null
	 * @throws Webhook_Exception
	 */
	protected function update_user( Customer $customer ): ?int {
		$result = $this->customer_repository->find_by_customer_id( $customer->get_customer_id() );

		// If customer not found, bail.
		if ( is_null( $result ) ) {
			throw Webhook_Exception::entity_doesnt_exist( Webhook_Subscriber::UPDATE, $this->webhook_type(), $customer );
		}

		return $this->customer_repository->update( $result->get_id(), $customer );
	}

	protected function delete_user( Customer $customer ): ?int {
		# code...
	}
}
