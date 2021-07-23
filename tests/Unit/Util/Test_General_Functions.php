<?php

/**
 * General Util function tests.
 *
 * @package PinkCrab\WC_Pink_Pos\Tests
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */

namespace PinkCrab\WC_Pink_Pos\Test\Unit\Util;

use PinkCrab\WC_Pink_Pos\Util\General_Functions;

class Test_General_Functions extends \WP_UnitTestCase {

	/** @testdox It should be possible to get a value from an array or null if does not exist, without generating errors. */
	public function test_maybe_get_value_from_array(): void {
		$array = array(
			'foo' => 1,
			'bar' => array( 1, 2, 3, 4 ),
			'baz' => 'string',
		);

		$this->assertEquals( 1, General_Functions::maybe_get_value_from_array( 'foo', $array ) );
		$this->assertEquals( array( 1, 2, 3, 4 ), General_Functions::maybe_get_value_from_array( 'bar', $array ) );
		$this->assertEquals( 'string', General_Functions::maybe_get_value_from_array( 'baz', $array ) );
		$this->assertNull( General_Functions::maybe_get_value_from_array( 'no', $array ) );
	}
}
