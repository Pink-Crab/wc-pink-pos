<?php

/**
 * Customer factory tests.
 *
 * @package PinkCrab\WC_Pink_Pos\Tests
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */

namespace PinkCrab\WC_Pink_Pos\Test\Unit\Customer;

use OutOfRangeException;
use PinkCrab\WC_Pink_Pos\Customer\Customer;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Factory;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Repository;

class Test_Customer_Factory extends \WP_UnitTestCase {

	/**
	 * Generates a mocked factory with access to the repository used to generate.
	 *
	 * @param callable|null $config
	 * @return \PinkCrab\WC_Pink_Pos\Customer\Customer_Factory
	 */
	public function create_factory( ?callable $config = null ): Customer_Factory {
		$repository = $this->createMock( Customer_Repository::class );

		if ( is_callable( $config ) ) {
			$repository = $config( $repository );
		}

		return new Customer_Factory( $repository );
	}

	/** @testdox It should be possible to create a customer from a webhook payload. */
	public function test_from_pink_pos_webhook(): void {
		$factory = $this->create_factory();

		// If no customer ID, should return null.
		$this->assertNull( $factory->from_pink_pos_webhook( array() ) );

		// If customer ID is empty return null.
		$this->assertNull( $factory->from_pink_pos_webhook( array( 'customer_id' => null ) ) );

		$customer = $factory->from_pink_pos_webhook(
			array(
				'customer_id' => 123,
				'name'        => 'Testy McTest',
				'phone'       => '123456',
			)
		);

		$this->assertEquals( 'Testy McTest', $customer->get_name() );
		$this->assertEquals( '123456', $customer->get_phone() );
		$this->assertEquals( '', $customer->get_email() );
		$this->assertEquals( '', $customer->get_delivery_address()->city() );
	}

	public function test_address_from_pink_pos_webhook(): void {
		$address = $this->create_factory()->address_from_pink_pos_webhook(
			array(
				'address_1' => '1 First Street',
				'address_2' => '2nd Town',
				'county'    => 'Countyshire',
			)
		);

		// Set values.
		$this->assertEquals( '1 First Street', $address->address_1() );
		$this->assertEquals( '2nd Town', $address->address_2() );
		$this->assertEquals( 'Countyshire', $address->county() );
		// Unset values
		$this->assertEquals( '', $address->country() );
		$this->assertEquals( '', $address->city() );
		$this->assertEquals( '', $address->postcode() );
	}

	/** @testdox When passed the payload from a pinkpos webhook, it should be possible to construct a customer model. */
	public function test_customer_from_payload(): void {
		$payload  = \file_get_contents( PC_TESTS_FIXTURES . '/Webhook/Customer_Webhook_Payload_Create.json' );
		$payload  = json_decode( $payload );
		$customer = $this->create_factory()->from_pink_pos_webhook( (array) $payload->data );

		$this->assertEquals( 'Customer Betty', $customer->get_name() );
		$this->assertEquals( 'betty@customer.com', $customer->get_email() );
		$this->assertEquals( '', $customer->get_phone() );
		$this->assertContains( 'phone', $customer->get_marketing() );
		$this->assertContains( 'Dislikes spoons', $customer->get_notes() );

		// Billing Address
		$this->assertEquals( '12 Street Road', $customer->get_billing_address()->address_1() );
		$this->assertEquals( '', $customer->get_billing_address()->address_2() );
		$this->assertEquals( 'Townsville', $customer->get_billing_address()->city() );
		$this->assertEquals( 'Countyshire', $customer->get_billing_address()->county() );
		$this->assertEquals( 'TO1 2CS', $customer->get_billing_address()->postcode() );
		$this->assertEquals( 'UK', $customer->get_billing_address()->country() );
		// Delivery Address
		$this->assertEquals( '24 Avenue Close', $customer->get_delivery_address()->address_1() );
		$this->assertEquals( 'Near Wilton', $customer->get_delivery_address()->address_2() );
		$this->assertEquals( 'Placeton', $customer->get_delivery_address()->city() );
		$this->assertEquals( 'Cityinghamshire', $customer->get_delivery_address()->county() );
		$this->assertEquals( 'PC1 14IO', $customer->get_delivery_address()->postcode() );
		$this->assertEquals( 'UK', $customer->get_delivery_address()->country() );
	}

	/** @testdox When creating a WC_Customer from a Customer, the email is required. */
	public function test_create_user_fail_if_email_empty(): void {
		$this->assertNull( $this->create_factory()->create_user( new Customer() ) );
	}

	/** @testdox When creating a WC_Customer from a Customer, a user with the same email must not already exist.*/
	public function test_create_user_fail_if_user_with_matching_email_exists(): void {
		$factory = $this->create_factory(
			function( Customer_Repository $repository ): Customer_Repository {
				$repository->method( 'find_by_email' )
					->willReturn( null );
				return $repository;
			}
		);

		$this->expectException( \Exception::class );
		$factory->create_user( ( new Customer() )->set_email( 'gg@gg.com' ) );
	}

	/** @testdox With a Customer (with email address) that has not already been registered, should be created. */
	public function test_create_user_success(): void {
		$factory = $this->create_factory(
			function( Customer_Repository $repository ): Customer_Repository {
				$repository->method( 'create' )
					->willReturn( 12 );
				$repository->method( 'find_by_email' )
					->willReturn( null );
				return $repository;
			}
		);

		$user_id = $factory->create_user( ( new Customer() )->set_email( 'gg@gg.com' ) );
		$this->assertEquals( 12, $user_id );
	}

}
