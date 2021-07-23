<?php

declare(strict_types=1);

/**
 * Handles all shared authentication callbacks.
 *
 * @package PinkCrab/WC_Pink_Pos
 * @subpackage authentication
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Webhook\Authentication;

use WP_REST_Request;
use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Settings;

class Webhook_Authentication {
	/**
	 * Webhook settings
	 *
	 * @var Webhook_Settings
	 */
	protected $webhook_settings;

	public function __construct( Webhook_Settings $webhook_settings ) {
		$this->webhook_settings = $webhook_settings;
	}

	/**
	 * Validate the api key in header.
	 *
	 * @return callable(\WP_REST_Request):bool
	 */
	public function validate_header_api_key(): callable {
		/**
		 * @param \WP_REST_Request $request
		 * @return bool
		 */
		return function( WP_REST_Request $request ): bool {
			return $request->get_header( 'pink-pos-api-key' ) === $this->webhook_settings->webhook_api_key();
		};
	}
}
