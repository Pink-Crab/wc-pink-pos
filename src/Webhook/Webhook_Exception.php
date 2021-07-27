<?php

declare(strict_types=1);

/**
 * Hook tags used throughout the webhook handler.
 *
 * @package PinkCrab/WC_Pink_Pos
 * @subpackage webhook
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Webhook;

use Exception;

class Webhook_Exception extends Exception {

	/**
	 * Exception for an invalid payload.
	 *
	 * @param string $action
	 * @param string $type
	 * @param mixed $payload
	 * @return self
	 * @code 200
	 */
	public static function invalid_payload( string $action, string $type, $payload ): self {
		return new self(
			\sprintf(
				'Invalid %s payload request with %s action [%s]',
				$type,
				$action,
			//phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
				\print_r( $payload, true )
			),
			200
		);
	}

	/**
	 * Exception for attempting to create and entity that already exists.
	 *
	 * @param string $action
	 * @param string $type
	 * @param mixed $entity
	 * @return self
	 * @code 201
	 */
	public static function entity_exists( string $action, string $type, $entity ): self {
		return new self(
			\sprintf(
				'Can not %s %s as already exits [%s]',
				$action,
				$type,
			//phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
				\print_r( $entity, true )
			),
			201
		);
	}

	/**
	 * Exception for attempting to update an entity that doesn't exist.
	 *
	 * @param string $action
	 * @param string $type
	 * @param mixed $entity
	 * @return self
	 * @code 201
	 */
	public static function entity_doesnt_exist( string $action, string $type, $entity ): self {
		return new self(
			\sprintf(
				'Can not %s %s as doesn\'t exit [%s]',
				$action,
				$type,
			//phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
				\print_r( $entity, true )
			),
			201
		);
	}

	/**
	 * Exception for an invalid action.
	 *
	 * @param string $action
	 * @param string $type
	 * @param mixed $payload
	 * @return self
	 * @code 202
	 */
	public static function invalid_action( string $action, string $type, $payload ): self {
		return new self(
			\sprintf(
				'%s is not a valid action for %s [%s]',
				$action,
				$type,
			//phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
				\print_r( $payload, true )
			),
			202
		);
	}
}
