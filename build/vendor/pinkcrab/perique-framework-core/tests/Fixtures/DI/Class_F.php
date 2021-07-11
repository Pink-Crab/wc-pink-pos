<?php

declare (strict_types=1);
/**
 * Class C
 * Injected with abstract
 *
 * @since 0.2.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI;

use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Abstract_B;
class Class_F
{
    /**
     * Dependency constructed
     *
     * @var Abstract_B
     */
    protected $dependency;
    /**
     * Create class.
     *
     * @param \PinkCrab\Perique\Tests\Fixtures\DI\Abstract_B $dependency
     */
    public function __construct(\pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Abstract_B $dependency)
    {
        $this->dependency = $dependency;
    }
    /**
     * Retutns the class name of the dependdency
     *
     * @return string
     */
    public function test() : string
    {
        return \get_class($this->dependency);
    }
}
