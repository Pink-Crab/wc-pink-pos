<?php

declare(strict_types=1);

/**
 * Settings helper for Webhook options
 *
 * @package PinkCrab/WC_Pink_Pos
 * @subpackage settings
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Webhook;

use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App_Config;

class Webhook_Settings {

	/**
	 * App config
	 *
	 * @var App_Config
	 */
	protected $app_config;

	/**
	 * The prefix applied to all webhook settings keys.
	 *
	 * @var string
	 */
	protected $settings_prefix;

	public function __construct( App_Config $app_config ) {
		$this->app_config      = $app_config;
		$this->settings_prefix = $this->app_config->additional( 'webhook' )->settings_prefix;
	}

	/**
	 * Prefixes the passed key.
	 *
	 * @param string $key
	 * @return string
	 */
	protected function prefix_key( string $key ): string {
		return $this->settings_prefix . $key;
	}

	/**
	 * Retrieves the webhook api key from settings.
	 *
	 * @return string
	 */
	public function webhook_api_key(): string {
		return get_option(
			$this->prefix_key( 'api_key' ),
			'TODO'
		);
	}
}
