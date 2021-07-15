<?php

declare (strict_types=1);
/**
 * Collection mock using the Indexed trait.
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Collection
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Collection\Tests\Fixtures;

use pc_pink_pos_0_0_1\PinkCrab\Collection\Collection;
use pc_pink_pos_0_0_1\PinkCrab\Collection\Traits\Indexed;
class Indexed_Collection extends \pc_pink_pos_0_0_1\PinkCrab\Collection\Collection
{
    use Indexed;
}
