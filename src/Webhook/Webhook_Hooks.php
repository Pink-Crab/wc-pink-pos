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

class Webhook_Hooks {

	/**
	 * Hook tag prefix;
	 */
	private const HOOK_PREFIX = 'pinkcrab/wc_pink_pos/webhook/';

	/**
	 * Action fired when a new payload comes in.
	 */
	public const WEBHOOK_EVENT = self::HOOK_PREFIX . 'new_payload';

	/**
	 * Action fired when request succesfully handled.
	 */
	public const WEBHOOK_REQUEST_SUCCESS = self::HOOK_PREFIX . 'request_success';

	/**
	 * Action fires when an invalid payload request comes in.
	 */
	public const INVALID_WEBHOOK_PAYLOAD = self::HOOK_PREFIX . 'invalid_payload';


}
