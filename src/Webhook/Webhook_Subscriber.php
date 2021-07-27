<?php

declare(strict_types=1);

/**
 * Abstract Webhook Subscriber
 *
 * Bases class for all Webhook Subscribers for all events broadcast
 * from the main PinkPOS instance.
 *
 * @package PinkCrab/WC_Pink_Pos
 * @subpackage webhook
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Webhook;

use Exception;
use WP_REST_Request;
use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Exception;

use WP_REST_Response;

abstract class Webhook_Subscriber {

	/**
	 * Actions.
	 */
	public const CREATE = 'create';
	public const UPDATE = 'update';
	public const DELETE = 'delete';

	/**
	 * Main callback method.
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	final public function __invoke( WP_REST_Request $request ): WP_REST_Response {

		/**
		 * Action fired on new request.
		 * @param WP_REST_Request    HTTP request.
		 * @param string             Webhook type.
		 */
		do_action( Webhook_Hooks::WEBHOOK_EVENT, $request, $this->webhook_type() );

		// Based on the request validation.
		if ( $this->validate_webhook_data( $request ) ) {

			// Attempt to handle request.
			try {
				$response = $this->handle_request( $request );
			} catch ( Exception $exception ) {

				/**
				 * Action fired for a Exception thrown.
				 * @param Exception              Exception thrown
				 * @param WP_HTTP_Request        The webhook data
				 * @param string                 The webhook type
				 */
				do_action( Webhook_Hooks::WEBHOOK_EXCEPTION_THROWN, $exception, $request, $this->webhook_type() );

				return new WP_REST_Response( array( 'error' => $exception->getMessage() ), 500 );
			}

			/**
			 * Action fired for a valid request.
			 * @param array<string, mixed>   The response array
			 * @param WP_HTTP_Request        The webhook data
			 * @param string $name           The webhook type
			 */
			do_action( Webhook_Hooks::WEBHOOK_REQUEST_SUCCESS, $response, $response, $this->webhook_type() );

			return new WP_REST_Response( $response );
		} else {

			/**
			 * Action fired for invalid request
			 * @param WP_HTTP_Request        The webhook data
			 * @param string                 The webhook type
			 */
			do_action( Webhook_Hooks::INVALID_WEBHOOK_PAYLOAD, $request, $this->webhook_type() );

			return new WP_REST_Response( array(), 400 );
		}
	}

	/**
	 * Returns the webhook type/domain
	 *
	 * @return string
	 */
	abstract public function webhook_type(): string;

	/**
	 * Validates the contents of webhook data.
	 *
	 * @param WP_REST_Request $request
	 * @return boolean
	 */
	abstract protected function validate_webhook_data( WP_REST_Request $request ): bool;

	/**
	 * Handles the request.
	 *
	 * @param WP_REST_Request $request
	 * @return array<string, mixed>
	 * @throws Webhook_Exception
	 */
	abstract public function handle_request( WP_REST_Request $request ): array;
}
