<?php

declare (strict_types=1);
/**
 * Class which has the DI cotainer as a dependency  
 *
 * @since 0.5.5
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Fixtures\Mock_Objects;

use pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container;
class Has_DI_Container
{
    /**
     * Test property
     *
     * @var \PinkCrab\Perique\Interfaces\DI_Container
     */
    public $di_container;
    public function __construct(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container $di_container)
    {
        $this->di_container = $di_container;
    }
    /**
     * Checks if the DI container is set
     *
     * @return bool
     */
    public function di_set() : bool
    {
        return \is_a($this->di_container, \pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container::class);
    }
}
