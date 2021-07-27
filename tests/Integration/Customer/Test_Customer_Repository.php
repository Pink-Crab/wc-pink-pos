<?php

/**
 * Customer Repository integration tests.
 *
 * @package PinkCrab\WC_Pink_Pos\Tests
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */

namespace PinkCrab\WC_Pink_Pos\Test\Integration\Customer;

use PinkCrab\WC_Pink_Pos\Customer\Customer;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Address;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Repository;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App_Config;

class Test_Customer_Repository extends \WP_UnitTestCase {

	/**
	 * Retruns a repository instance.
	 *
	 * @return \PinkCrab\WC_Pink_Pos\Customer\Customer_Repository
	 */
	public function get_repository(): Customer_Repository {
		return  new Customer_Repository(
			new App_Config(
				array(
					'meta' => array(
						'user' => array(
							'customer_id'        => 'pink_pos_test_customer_id',
							'customer_marketing' => 'pink_pos_test_customer_marketing',
							'customer_notes'     => 'pink_pos_test_customer_notes',
						),
					),
				)
			)
		);
	}

	/**
	 * Returns a populated customer.
	 *
	 * @param int $id
	 * @return \PinkCrab\WC_Pink_Pos\Customer\Customer
	 */
	public function get_customer( int $id ): Customer {
		return ( new Customer( $id ) )
			->set_email( 'customer@pc.co' )
			->set_name( 'customer' )
			->set_phone( '0123456789' )
			->set_marketing( array( 'email' ) )
			->set_notes( array( 'customer note' ) )
			->set_billing_address(
				new Customer_Address(
					'billing street',
					'billing_village',
					'near billing town',
					'billingcounty',
					'BI1 1NG',
					'UK'
				)
			)
			->set_delivery_address(
				new Customer_Address(
					'shipping street',
					'shipping_village',
					'near shipping town',
					'Shippingcounty',
					'SH1 9NG',
					'UK'
				)
			);
	}

	/** @testdox [INT] It should be possible to find a customer based on its user_id and get a WooCommerce Customer object. */
	public function test_find(): void {

		$new_customer = \wc_create_new_customer( 'test_find@g.com', 'test_find' );
		$result       = $this->get_repository()->find( $new_customer );

		$this->assertInstanceOf( \WC_Customer::class, $result );
		$this->assertEquals( 'test_find@g.com', $result->get_email() );
		$this->assertEquals( 'test_find', $result->get_username() );

		// Returns null if not found.
		$this->assertNull( $result = $this->get_repository()->find( \PHP_INT_MAX ) );
	}

	/** @testdox [INT] It should be possible to find a customer based on its email address and get a WooCommerce Customer object. */
	public function test_find_by_email(): void {

		\wc_create_new_customer( 'test_find_by_email@g.com', 'test_find_by_email' );
		$result = $this->get_repository()->find_by_email( 'test_find_by_email@g.com' );

		$this->assertInstanceOf( \WC_Customer::class, $result );
		$this->assertEquals( 'test_find_by_email@g.com', $result->get_email() );
		$this->assertEquals( 'test_find_by_email', $result->get_username() );

		// Returns null if not found.
		$this->assertNull( $result = $this->get_repository()->find_by_email( 'no@customer.co' ) );
	}

	/** @testdox [INT] It should be possible to create a WP_User/WC_Customer from a Customer object. */
	public function test_create(): void {

		$customer = $this->get_customer( 24 )->set_email( 'test@create.pc' );
		$this->get_repository()->create( $customer );

		$result = $this->get_repository()->find_by_email( 'test@create.pc' );
		$this->assertInstanceOf( \WC_Customer::class, $result );

		// Check as WP User
		$wp_user = new \WP_User( $result->get_id() );
		$this->assertEquals( 'customer', $wp_user->data->display_name );
		$this->assertEquals( 'test@create.pc', $wp_user->data->user_email );
		$this->assertEquals( 'test@create.pc', $wp_user->data->user_login );

		// Check WC_Customer
		$wc_customer = new \WC_Customer( $result->get_id() );
		$this->assertEquals( '0123456789', $wc_customer->get_billing_phone() );
		$this->assertContains( 'email', $wc_customer->get_meta( 'pink_pos_test_customer_marketing' ) );
		$this->assertContains( 'customer note', $wc_customer->get_meta( 'pink_pos_test_customer_notes' ) );
		$this->assertEquals( '24', $wc_customer->get_meta( 'pink_pos_test_customer_id' ) );

		// Billing Address
		$this->assertEquals( 'billing street', $wc_customer->get_billing_address_1() );
		$this->assertEquals( 'billing_village', $wc_customer->get_billing_address_2() );
		$this->assertEquals( 'near billing town', $wc_customer->get_billing_city() );
		$this->assertEquals( 'billingcounty', $wc_customer->get_billing_state() );
		$this->assertEquals( 'BI1 1NG', $wc_customer->get_billing_postcode() );
		$this->assertEquals( 'UK', $wc_customer->get_billing_country() );

		// Delivery Address
		$this->assertEquals( 'shipping street', $wc_customer->get_shipping_address_1() );
		$this->assertEquals( 'shipping_village', $wc_customer->get_shipping_address_2() );
		$this->assertEquals( 'near shipping town', $wc_customer->get_shipping_city() );
		$this->assertEquals( 'Shippingcounty', $wc_customer->get_shipping_state() );
		$this->assertEquals( 'SH1 9NG', $wc_customer->get_shipping_postcode() );
		$this->assertEquals( 'UK', $wc_customer->get_shipping_country() );
	}

	/** @testdox It should be possible to check if a customer exists based on the customer id.*/
	public function test_customer_exists(): void {
		$customer = $this->get_customer( 25 )->set_email( 'why@why.com' );
		$this->get_repository()->create( $customer );

		$this->assertTrue( $this->get_repository()->customer_id_exists( 25 ) );
		$this->assertFalse( $this->get_repository()->customer_id_exists( \PHP_INT_MAX ) );
	}

	/** @testdox [INT] If there is an error creating a user, null should be returned when creating a new user/wc_customer */
	public function test_fail_create(): void {
		$customer = $this->get_customer( 26 )->set_email( '__^^__' );
		$user_id  = $this->get_repository()->create( $customer );
		$this->assertNull( $user_id );

	}

	/** @testdox [INT] It should be possible to update an existing user based on a new customer model. */
	public function test_update(): void {
		$customer = $this->get_customer( 28 )->set_email( 'test@update.pc' );
		$user_id  = $this->get_repository()->create( $customer );

		// Update the customer.
		$updated_customer = $customer->set_phone( '1122334455' )->set_marketing( array( 'sms' ) );
		$updated_user_id  = $this->get_repository()->update( $user_id, $updated_customer );

		$this->assertEquals( $user_id, $updated_user_id );

		// Check
		$result = $this->get_repository()->find_by_email( 'test@update.pc' );
		$this->assertInstanceOf( \WC_Customer::class, $result );

		$wc_customer = new \WC_Customer( $result->get_id() );
		$this->assertEquals( '1122334455', $wc_customer->get_billing_phone() );
		$this->assertContains( 'sms', $wc_customer->get_meta( 'pink_pos_test_customer_marketing' ) );

		// Returns null if invaild id.
		$invalid_user_id = $this->get_repository()->update( \PHP_INT_MAX, $updated_customer );
		$this->assertNull( $invalid_user_id );
	}


	/** @testdox [INT] If there is an error updating a user, null should be returned when creating a new user/wc_customer */
	public function test_fail_update(): void {
		$customer = $this->get_customer( 30 );
		$user_id  = $this->get_repository()->update( \PHP_INT_MAX, $customer );
		$this->assertNull( $user_id );
	}

	/** @testdox [INT] It should be possible to delete a valid user. */
	public function test_delete(): void {
		$customer = $this->get_customer( 32 )->set_email( 'test_delete@email.com' );
		$user_id  = $this->get_repository()->create( $customer );

		// Check it exists
		$this->assertInstanceOf( \WC_Customer::class, $this->get_repository()->find_by_email( 'test_delete@email.com' ) );

		// Delete
		$this->assertTrue( $this->get_repository()->delete( $user_id, $customer ) );
		$this->assertNull( $this->get_repository()->find_by_email( 'test_delete@email.com' ) );
	}

	/** @testdox [INT] If there is an error deleting a user, false should be returned when creating a new user/wc_customer */
	public function test_fail_delete(): void {
		$customer     = $this->get_customer( 34 );
		$confirmation = $this->get_repository()->delete( \PHP_INT_MAX, $customer );
		$this->assertFalse( $confirmation );
	}

}
