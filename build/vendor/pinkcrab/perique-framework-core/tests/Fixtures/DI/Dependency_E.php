<?php

declare (strict_types=1);
/**
 * Dependency E
 * Implements Interface_A
 *
 * @since 0.2.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI;

use pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Interface_A;
class Dependency_E implements \pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Interface_A
{
    public function foo()
    {
        return self::class;
    }
}
