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
namespace pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI;

use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Interface_A;
class Dependency_E implements \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Interface_A
{
    public function foo()
    {
        return self::class;
    }
}
