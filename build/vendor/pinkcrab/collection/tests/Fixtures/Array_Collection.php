<?php

declare (strict_types=1);
/**
 * Collection mock using the Indexed & Has_ArrayAccess trait.
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Collection
 */
namespace pinkcrab_cccp_0_0_1\PinkCrab\Collection\Tests\Fixtures;

use ArrayAccess;
use pinkcrab_cccp_0_0_1\PinkCrab\Collection\Collection;
use pinkcrab_cccp_0_0_1\PinkCrab\Collection\Traits\Indexed;
use pinkcrab_cccp_0_0_1\PinkCrab\Collection\Traits\Has_ArrayAccess;
class Array_Collection extends \pinkcrab_cccp_0_0_1\PinkCrab\Collection\Collection implements \ArrayAccess
{
    use Indexed, Has_ArrayAccess;
}
