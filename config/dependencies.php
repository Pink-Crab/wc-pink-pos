<?php

declare(strict_types=1);

use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Subscriber;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\Renderable;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App_Config;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Services\View\PHP_Engine;
use PinkCrab\WC_Pink_Pos\Webhook\Customer\Customer_Route_Controller;
use PinkCrab\WC_Pink_Pos\Webhook\Customer\Customer_Webhook_Subscriber;

/**
 * All custom rules for the DI Container.
 * See docs at https://app.gitbook.com/@glynn-quelch/s/pinkcrab/application/dependency-injection
 *
 * @package PinkCrab\WC_Pink_Pos
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */

return array(
	'*'                              => array(
		'substitutions' => array(
			Renderable::class => new PHP_Engine(
				\dirname( __DIR__, 1 ) . '/views'
			),
			App_Config::class => new App_Config( require __DIR__ . '/settings.php' ),
		),
	),

	// WEBHOOKS SUBSCRIBERS
	Customer_Route_Controller::class => array(
		'substitutions' => array(
			Webhook_Subscriber::class => Customer_Webhook_Subscriber::class,
		),
	),
);
