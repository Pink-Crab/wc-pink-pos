<?php

declare(strict_types=1);

/**
 * Repository for working with customers.
 *
 * @package PinkCrab/WC_Pink_Pos
 * @Customer Customer
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Customer;

use stdClass;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App_Config;

class Customer_Repository {

	/**
	 * App config
	 *
	 * @var App_Config
	 */
	protected $app_config;

	public function __construct( App_Config $app_config ) {
		$this->app_config = $app_config;
	}

	/**
	 * Attempts to fetch a customer based on user ID
	 *
	 * @param int $id
	 * @return \WC_Customer|null
	 */
	public function find( int $id ): ?\WC_Customer {
		$user = \get_user_by( 'id', $id );

		if ( ! is_object( $user ) || ! is_a( $user, \WP_User::class ) ) {
			return null;
		}

		return new \WC_Customer( $user->ID );
	}

	/**
	 * Attempts to find customer by email.
	 *
	 * @param string $email
	 * @return \WC_Customer|null
	 */
	public function find_by_email( string $email ): ?\WC_Customer {
		$user = \get_user_by( 'email', $email );
		if ( ! is_object( $user ) || ! is_a( $user, \WP_User::class ) ) {
			return null;
		}

		return new \WC_Customer( $user->ID );
	}

	/**
	 * Attempts to find customer by customer id.
	 *
	 * @param int $customer_id
	 * @return \WC_Customer|null
	 */
	//phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	public function find_by_customer_id( int $customer_id ): ?\WC_Customer {
		return null;
	}

	/**
	 * Checks if a customer exists.
	 *
	 * @param int $id
	 * @return bool
	 */
	public function exists( int $id ): bool {
		return ! is_null( $this->find( $id ) );
	}

	/**
	 * Attempts to create a customer
	 *
	 * @param Customer $customer
	 * @return int|null
	 */
	public function create( Customer $customer ): ?int {
		$user_id = \wc_create_new_customer( $customer->get_email(), $customer->get_email() );

		// If we have a wp_error bail.
		if ( \is_wp_error( $user_id ) ) {
			return null;
		}

		return $this->update( $user_id, $customer );
	}

	/**
	 * Updates an existing WP User with details from Customer.
	 *
	 * @param int $user_id
	 * @param Customer $customer
	 * @return int|null
	 */
	public function update( int $user_id, Customer $customer ): ?int {
		// Populate user data.
		$user_id = \wp_update_user(
			array(
				'ID'           => $user_id,
				'display_name' => $customer->get_name(),
			)
		);

		// If we have a wp_error bail.
		if ( \is_wp_error( $user_id ) ) {
			return null;
		}
		// Populate meta.
		\update_user_meta( $user_id, 'billing_email', $customer->get_email() );
		\update_user_meta( $user_id, 'billing_address_1', $customer->get_billing_address()->address_1() );
		\update_user_meta( $user_id, 'billing_address_2', $customer->get_billing_address()->address_2() );
		\update_user_meta( $user_id, 'billing_city', $customer->get_billing_address()->city() );
		\update_user_meta( $user_id, 'billing_postcode', $customer->get_billing_address()->postcode() );
		\update_user_meta( $user_id, 'billing_country', $customer->get_billing_address()->country() );
		\update_user_meta( $user_id, 'billing_state', $customer->get_billing_address()->county() );
		\update_user_meta( $user_id, 'billing_phone', $customer->get_phone() );

		\update_user_meta( $user_id, 'shipping_address_1', $customer->get_delivery_address()->address_1() );
		\update_user_meta( $user_id, 'shipping_address_2', $customer->get_delivery_address()->address_2() );
		\update_user_meta( $user_id, 'shipping_city', $customer->get_delivery_address()->city() );
		\update_user_meta( $user_id, 'shipping_postcode', $customer->get_delivery_address()->postcode() );
		\update_user_meta( $user_id, 'shipping_country', $customer->get_delivery_address()->country() );
		\update_user_meta( $user_id, 'shipping_state', $customer->get_delivery_address()->county() );

		\update_user_meta( $user_id, $this->app_config->user_meta( 'customer_id' ), $customer->get_customer_id() );
		\update_user_meta( $user_id, $this->app_config->user_meta( 'customer_marketing' ), $customer->get_marketing() );
		\update_user_meta( $user_id, $this->app_config->user_meta( 'customer_notes' ), $customer->get_notes() );

		return $user_id;
	}


}
