<?php

declare (strict_types=1);
/**
 * Mock object that implements Hookable
 *
 * @since 0.2.3
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Fixtures\Mock_Objects\Hookable;

use pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Loader;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\Hookable;
class Hookable_Mock implements \pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\Hookable
{
    /**
     * Registers a single hook (Hookable_Mock) echos Hookable_Mock
     *
     * @param \PinkCrab\Loader\Hook_Loader $loader
     * @return void
     */
    public function register(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Loader $loader) : void
    {
        $loader->action('Hookable_Mock', function () {
            echo 'Hookable_Mock';
        });
    }
}
