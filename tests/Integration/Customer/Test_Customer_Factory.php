<?php

/**
 * Customer factory tests.
 *
 * @package PinkCrab\WC_Pink_Pos\Tests
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */

namespace PinkCrab\WC_Pink_Pos\Test\Integration\Customer;

use Exception;
use PinkCrab\WC_Pink_Pos\Customer\Customer;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Factory;
use PinkCrab\WC_Pink_Pos\Customer\Customer_Repository;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App_Config;

class Test_Customer_Factory extends \WP_UnitTestCase {

	public function get_factory(): Customer_Factory {
		return new Customer_Factory(
			new Customer_Repository(
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
			)
		);
	}

	/** @testdox [INT] When attempting to create a customer, an existing email should result in an error. */
	public function test_throws_exception_if_user_with_email_exists(): void {
		// Create user.
		\wp_create_user( 'exists', '1234', 'user@site.com' );

		$this->expectException( Exception::class );
		$this->expectExceptionMessage( 'Customer with email user@site.com already exists' );

		$this->get_factory()->create_user(
			( new Customer )->set_email( 'user@site.com' )
		);
	}

	/** @testdox [INT] It should be possible to create a valid WC_Customer from a Customer model */
	public function test_create_valid_user(): void {
		$payload  = \file_get_contents( PC_TESTS_FIXTURES . '/Webhook/Customer_Webhook_Payload_Create.json' );
		$payload  = json_decode( $payload );
		$customer = $this->get_factory()->from_pink_pos_webhook( (array) $payload->data );
		$user_id  = $this->get_factory()->create_user( $customer );

		// Check as WP User
		$wp_user = new \WP_User( $user_id );
		$this->assertEquals( 'Customer Betty', $wp_user->data->display_name );
		$this->assertEquals( 'betty@customer.com', $wp_user->data->user_email );
		$this->assertEquals( 'betty@customer.com', $wp_user->data->user_login );

		// Check WC_Customer
		$wc_customer = new \WC_Customer( $user_id );
		$this->assertEquals( '', $wc_customer->get_billing_phone() );
		$this->assertContains( 'phone', $wc_customer->get_meta( 'pink_pos_test_customer_marketing' ) );
		$this->assertContains( 'Dislikes spoons', $wc_customer->get_meta( 'pink_pos_test_customer_notes' ) );

		// Billing Address
		$this->assertEquals( '12 Street Road', $wc_customer->get_billing_address_1() );
		$this->assertEquals( '', $wc_customer->get_billing_address_2() );
		$this->assertEquals( 'Townsville', $wc_customer->get_billing_city() );
		$this->assertEquals( 'Countyshire', $wc_customer->get_billing_state() );
		$this->assertEquals( 'TO1 2CS', $wc_customer->get_billing_postcode() );
		$this->assertEquals( 'UK', $wc_customer->get_billing_country() );

		// Delivery Address
		$this->assertEquals( '24 Avenue Close', $wc_customer->get_shipping_address_1() );
		$this->assertEquals( 'Near Wilton', $wc_customer->get_shipping_address_2() );
		$this->assertEquals( 'Placeton', $wc_customer->get_shipping_city() );
		$this->assertEquals( 'Cityinghamshire', $wc_customer->get_shipping_state() );
		$this->assertEquals( 'PC1 14IO', $wc_customer->get_shipping_postcode() );
		$this->assertEquals( 'UK', $wc_customer->get_shipping_country() );

	}
}

