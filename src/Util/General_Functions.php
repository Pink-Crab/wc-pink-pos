<?php

declare(strict_types=1);

/**
 * General helper functions
 *
 * @package PinkCrab/WC_Pink_Pos
 * @Customer Customer
 * @since 0.1.0
 * @author Glynn <glynn@pinkcrab.co.uk>
 */

namespace PinkCrab\WC_Pink_Pos\Util;

class General_Functions {

	/**
	 * Attempts to get a value
	 *
	 * @param string $property
	 * @param array $source
	 * @return void
	 */
	public static function maybe_get_value_from_array( string $property, array $source ) {
		return array_key_exists( $property, $source )
		? $source[ $property ]
		: null;
	}
}
