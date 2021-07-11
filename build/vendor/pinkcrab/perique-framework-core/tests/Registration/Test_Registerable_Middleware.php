<?php

declare (strict_types=1);
/**
 * Test for Hookable Middleware
 *
 * @since 0.4.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Registration;

use pinkcrab_cccp_0_0_1\WP_UnitTestCase;
use pinkcrab_cccp_0_0_1\PinkCrab\Loader\Hook_Loader;
use pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\Mock_Objects\Sample_Class;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\Mock_Objects\Hookable\Hookable_Mock;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Registration\Middleware\Hookable_Middleware;
class Test_Hookable_Middleware extends \WP_UnitTestCase
{
    /** @testdox Hookable classes must have access to the current loader, for them to register all filter and action hooks. */
    public function test_can_be_constructed_with_loader() : void
    {
        $loader = new \pinkcrab_cccp_0_0_1\PinkCrab\Loader\Hook_Loader();
        $hookable = new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Registration\Middleware\Hookable_Middleware($loader);
        $this->assertSame($loader, \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($hookable, 'loader'));
    }
    /** @testdox When processes only classes which implement the Hookable class will be passed the loader for subscribing all hook calls. */
    public function test_only_processes_classes_that_implement_hookable() : void
    {
        $loader = new \pinkcrab_cccp_0_0_1\PinkCrab\Loader\Hook_Loader();
        $hookable = new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Registration\Middleware\Hookable_Middleware($loader);
        // Process hookable class
        $hookable->process(new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\Mock_Objects\Hookable\Hookable_Mock());
        // Process none hookable class
        $hookable->process(new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\Mock_Objects\Sample_Class());
        // Should only be the Hookable_Mock hook added.
        $hooks = \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($loader, 'hooks');
        $this->assertCount(1, $hooks);
        $this->assertEquals('Hookable_Mock', $hooks->pop()->get_handle());
    }
}
