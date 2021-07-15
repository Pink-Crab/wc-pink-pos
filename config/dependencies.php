<?php

declare(strict_types=1);

use PinkCrab\WC_Pink_Pos\Webhook\Webhook_Subscriber;
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
	// Sets the base path for views.
	// If you are using a different views path, please update in PHP_Engine args
	// Remove this if not planning to use the View or replace if using BladeOne
	'*'                              => array(
		'substitutions' => array(
			PinkCrab\Perique\Interfaces\Renderable::class
				=> new PinkCrab\Perique\Services\View\PHP_Engine(
					\dirname( __DIR__, 1 ) . '/views'
				),
		),
	),

	// WEBHOOKS SUBSCRIBERS
	Customer_Route_Controller::class => array(
		'substitutions' => array(
			Webhook_Subscriber::class => Customer_Webhook_Subscriber::class,
		),
	),
);
