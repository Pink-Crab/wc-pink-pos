<?php

declare (strict_types=1);
/**
 * Class H
 * Injected with Interface_A
 *
 * @since 0.2.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI;

use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Interface_A;
class Class_H
{
    /**
     * Dependency constructed
     *
     * @var Interface_A
     */
    protected $dependency;
    /**
     * Create class.
     *
     * @param \PinkCrab\Perique\Tests\Fixtures\DI\Interface_A $dependency
     */
    public function __construct(\pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Interface_A $dependency)
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
