<?php

declare (strict_types=1);
/**
 * Dependency C
 * Extends Abstract_B
 *
 * @since 0.2.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI;

use pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Abstract_B;
class Dependency_C extends \pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Abstract_B
{
    public function foo()
    {
        return self::class;
    }
}
