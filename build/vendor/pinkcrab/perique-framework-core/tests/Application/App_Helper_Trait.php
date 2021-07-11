<?php

declare (strict_types=1);
/**
 * Helper trait for all App tests
 * Includes clearing the internal state of an existing instance.
 *
 * @since 0.4.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Application;

use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App;
use pinkcrab_cccp_0_0_1\Dice\Dice;
use pinkcrab_cccp_0_0_1\PinkCrab\Loader\Hook_Loader;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Dice\PinkCrab_Dice;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Registration\Registration_Service;
use pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects;
trait App_Helper_Trait
{
    /**
     * Resets the any existing App isn'tance with default properties.
     *
     * @return void
     */
    protected static function unset_app_instance() : void
    {
        $app = new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App();
        \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'app_config', null);
        \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'container', null);
        \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'registration', null);
        \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'loader', null);
        \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::set_property($app, 'booted', \false);
        $app = null;
    }
    /**
     * Returns an instance of app (not booted) populated with actual
     * service objects.
     *
     * No registration classes are added, di has no rules, loader is empty
     * but there is the settings from the Fixtures/Application added so we can 
     * use template paths in the App:view() tests.
     *
     * Is a plain and basic instance.
     *
     * @return App
     */
    protected function pre_populated_app_provider() : \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App
    {
        // Build and populate the app.
        $app = new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App();
        $registration = new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Registration\Registration_Service();
        $container = new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Dice\PinkCrab_Dice(new \pinkcrab_cccp_0_0_1\Dice\Dice());
        $loader = new \pinkcrab_cccp_0_0_1\PinkCrab\Loader\Hook_Loader();
        $app->set_container($container);
        $app->set_registration_services($registration);
        $app->set_loader($loader);
        $app->set_app_config(include FIXTURES_PATH . '/Application/settings.php');
        return $app;
    }
}
