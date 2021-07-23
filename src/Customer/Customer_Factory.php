<?php

declare(strict_types=1);

/**
 * Customer and address factory
 *
 * @package PinkCrab/WC_Pink_Pos
 * @Customer Customer
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Customer;

use Exception;
use PinkCrab\WC_Pink_Pos\Customer\Customer;
use PinkCrab\WC_Pink_Pos\Util\General_Functions;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Repository;

class Customer_Factory {

	/**
	 * The customer repository
	 *
	 * @var Customer_Repository
	 */
	protected $customer_repository;

	public function __construct( Customer_Repository $customer_repository ) {
		$this->customer_repository = $customer_repository;
	}

	/**
	 * Generates from a pink pos webhook payload
	 *
	 * @param array<mixed> $payload
	 * @return Customer|null
	 */
	public function from_pink_pos_webhook( array $payload ): ?Customer {
		// Bail if we have no user ID.
		if ( ! \array_key_exists( 'customer_id', $payload )
		|| empty( $payload['customer_id'] ) ) {
			return null;
		}

		$customer = new Customer( (int) $payload['customer_id'] );

		$customer->set_name( General_Functions::maybe_get_value_from_array( 'name', $payload ) ?? '' );
		$customer->set_email( General_Functions::maybe_get_value_from_array( 'email', $payload ) ?? '' );
		$customer->set_phone( General_Functions::maybe_get_value_from_array( 'phone', $payload ) ?? '' );
		$customer->set_marketing( General_Functions::maybe_get_value_from_array( 'marketing', $payload ) ?? array() );
		$customer->set_notes( General_Functions::maybe_get_value_from_array( 'notes', $payload ) ?? array() );
		$customer->set_billing_address(
			$this->address_from_pink_pos_webhook( (array) General_Functions::maybe_get_value_from_array( 'billing_address', $payload ) ?? array() )
		);
		$customer->set_delivery_address(
			$this->address_from_pink_pos_webhook( (array) General_Functions::maybe_get_value_from_array( 'delivery_address', $payload ) ?? array() )
		);

		return $customer;
	}

	/**
	 * Maps a customer address from pink pos webhook payload.
	 *
	 * @param array $payload_address
	 * @return Customer_Address
	 */
	public function address_from_pink_pos_webhook( array $payload_address ): Customer_Address {
		return new Customer_Address(
			General_Functions::maybe_get_value_from_array( 'address_1', $payload_address ) ?? '',
			General_Functions::maybe_get_value_from_array( 'address_2', $payload_address ) ?? '',
			General_Functions::maybe_get_value_from_array( 'city', $payload_address ) ?? '',
			General_Functions::maybe_get_value_from_array( 'county', $payload_address ) ?? '',
			General_Functions::maybe_get_value_from_array( 'postcode', $payload_address ) ?? '',
			General_Functions::maybe_get_value_from_array( 'country', $payload_address ) ?? '',
		);
	}

	/**
	 * Creates a user if it doesn't already exist.
	 *
	 * @param Customer $customer
	 * @return int|null
	 * @throws Exception
	 */
	public function create_user( Customer $customer ): ?int {

		// If defined customer has no email, bail.
		if ( '' === $customer->get_email() ) {
			return null;
		}

		// If user already exists with this email,throw.
		if ( $this->customer_repository->find_by_email( $customer->get_email() ) ) {
			throw new Exception(
				\sprintf( 'Customer with email %s already exists', $customer->get_email() )
			);
		}

		$user_id = $this->customer_repository->create( $customer );

		// If we dont have a user id, throw.
		if ( ! is_int( $user_id ) ) {
			throw new Exception(
				\sprintf( 'Failed to create customer [%s]', print_r( $customer, true ) )
			);
		}

		return $user_id;
	}

}
