<?php

/**
 * Customer webhook subscriber
 *
 * @package PinkCrab\WC_Pink_Pos\Tests
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */

namespace PinkCrab\WC_Pink_Pos\Test\Unit\Webhook\Customer;

use WP_REST_Request;
use PinkCrab\WC_Pink_Pos\Webhook\Customer\Customer_Webhook_Subscriber;

class Test_Customer_Webhook_Subscriber extends \WP_UnitTestCase {

	public function mock_payload( ?callable $config = null ) {
		$payload = \file_get_contents( PC_TESTS_FIXTURES . '/Webhook/Customer_Webhook_Payload_Create.json' );
		return $config ? $config( $payload ) : $payload;
	}

	public function test_validate_webhook_data(): void {
		$subscriber = new Customer_Webhook_Subscriber();
        $request = new WP_REST_Request('POST');
        $request->set_body()
        dump($this->mock_payload('json_decode'), $subscriber);

	}
}
