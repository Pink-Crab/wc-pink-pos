<?php

namespace pc_pink_pos_0_0_1;

/**
 * Sample Test
 *
 * @package PinkCrab/Tests
 */
class Test_Test extends \WP_UnitTestCase
{
    function test_wordpress_and_plugin_are_loaded()
    {
        $this->assertTrue(\function_exists('pc_pink_pos_0_0_1\\do_action'));
    }
    function test_wp_phpunit_is_loaded_via_composer()
    {
        $this->assertStringStartsWith(\dirname(__DIR__) . '/vendor/', \getenv('WP_PHPUNIT__DIR'));
        $this->assertStringStartsWith(\dirname(__DIR__) . '/vendor/', (new \ReflectionClass('WP_UnitTestCase'))->getFileName());
    }
}
/**
 * Sample Test
 *
 * @package PinkCrab/Tests
 */
\class_alias('pc_pink_pos_0_0_1\\Test_Test', 'Test_Test', \false);
