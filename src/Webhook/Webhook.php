<?php

declare(strict_types=1);

/**
 * Webhook Model
 *
 * @package PinkCrab/WC_Pink_Pos
 * @subpackage webhook
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Webhook;

class Webhook {

	/**
	 * Webhook Type.
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Webhook Action
	 *
	 * @var string
	 */
	public $action;

	/**
	 * The raw (JSON) payload
	 *
	 * @var string
	 */
	public $payload_raw;

	/**
	 * Decoded data from webhook call
	 *
	 * @var stdClass
	 */
	public $data;

	/**
	 * Webhook source ip
	 *
	 * @var string
	 */
	public $source_ip;

	/**
	 * Webhook source URL.
	 *
	 * @var string
	 */
	public $source_url;
}
