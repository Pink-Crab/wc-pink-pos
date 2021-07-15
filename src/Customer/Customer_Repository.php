<?php

declare(strict_types=1);

/**
 * Repository for working with customers.
 *
 * @package PinkCrab/WC_Pink_Pos
 * @Customer webhook
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Customer;

class Customer_Repository {

	/**
	 * Attempts to fetch a customer based on user ID
	 *
	 * @param int $id
	 * @return \WC_Customer|null
	 */
	public function find( int $id ): ?\WC_Customer {
		# code...
	}

	/**
	 * Checks if a customer exists.
	 *
	 * @param int $id
	 * @return bool
	 */
	public function exists( int $id ): bool {
		# code...
	}

	/**
	 * Queries users based on the args passed.
	 * Maps all users to WC_Customers.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_user_query/
	 * @param array<string, mixed> $args
	 * @return \WC_Customer[]
	 */
	public function query( array $args ): array {
		// Ensure role is set as a fallback
		$args          = \array_merge( array( 'role' => 'customer' ), $args );
		$wp_user_query = new \WP_User_Query( $args );
		return array_map(
			fn( \WP_User $user): \WC_Customer => new \WC_Customer( $user->ID ),
			$wp_user_query->get_results()
		);
	}
}
