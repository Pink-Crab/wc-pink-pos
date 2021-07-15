<?php

declare (strict_types=1);
/**
 * Main App Container Test.
 *
 * @since 0.4.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Application;

use pc_pink_pos_0_0_1\Dice\Dice;
use Exception;
use pc_pink_pos_0_0_1\WP_UnitTestCase;
use pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Loader;
use pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\Config;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App_Config;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Services\Dice\PinkCrab_Dice;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Application\Test_App_Config;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\Registration_Middleware;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Application\App_Helper_Trait;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Services\Registration\Registration_Service;
class Test_App extends \WP_UnitTestCase
{
    /**
     * @method self::unset_app_instance();
     */
    use App_Helper_Trait;
    public function tearDown() : void
    {
        self::unset_app_instance();
    }
    /** @testdox When a container is passed to the application, it should be set as an internal property of the app. */
    public function test_set_container() : void
    {
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $container = $this->createMock(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container::class);
        $app->set_container($container);
        $this->assertSame($container, \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($app, 'container'));
    }
    /** @testdox The app should only allow one container to set, attempting to set another should cause the process to fail. */
    public function test_set_container_exception() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(2);
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $container = $this->createMock(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container::class);
        $app->set_container($container);
        $app->set_container($container);
    }
    /** @testdox A set of configs for the application can be bound as App_Config */
    public function test_set_app_config() : void
    {
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $app->set_app_config(array());
        $this->assertInstanceOf(\pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App_Config::class, \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($app, 'app_config'));
    }
    /** @testdox The applications config should only be settable once attempting to set another should cause the process to fail. */
    public function test_set_app_config_exception() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(5);
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $app->set_app_config(array());
        $app->set_app_config(array());
    }
    /** @testdox The registration service should be setable and bound to the registarion property */
    public function test_set_registration_services() : void
    {
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $registration = $this->createMock(\pc_pink_pos_0_0_1\PinkCrab\Perique\Services\Registration\Registration_Service::class);
        $app->set_registration_services($registration);
        $this->assertSame($registration, \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($app, 'registration'));
    }
    /** @testdox The applications registration service should only be settable once, attempting to set another should cause the process to fail. */
    public function test_set_registration_services_exception() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(7);
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $registration = $this->createMock(\pc_pink_pos_0_0_1\PinkCrab\Perique\Services\Registration\Registration_Service::class);
        $app->set_registration_services($registration);
        $app->set_registration_services($registration);
    }
    /** @testdox The loader should be setable and bound to the loader property */
    public function test_set_loader() : void
    {
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $loader = $this->createMock(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Loader::class);
        $app->set_loader($loader);
        $this->assertSame($loader, \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($app, 'loader'));
    }
    /** @testdox The applications loader should only be settable once, attempting to set another should cause the process to fail. */
    public function test_set_loader_exception() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(8);
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $loader = $this->createMock(\pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Loader::class);
        $app->set_loader($loader);
        $app->set_loader($loader);
    }
    /** @testdox The applications container should have an access point so custom rules can be added before the app is booted. */
    public function test_container_config() : void
    {
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $container = $this->createMock(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container::class);
        $app->set_container($container);
        $app->container_config(function (\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container $container) : void {
            $this->assertInstanceOf(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container::class, $container);
        });
    }
    /** @testdox Trying to configure the container before its set should result in an error and ending the intialisation. */
    public function test_container_config_exception() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(1);
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $app->container_config(function (\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container $container) : void {
            $this->assertInstanceOf(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container::class, $container);
        });
    }
    /** @testdox Additionl functionality should be added at boot up through the means of middleware */
    public function test_registration_middleware() : void
    {
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $registration = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Services\Registration\Registration_Service();
        $middleware = $this->createMock(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\Registration_Middleware::class);
        $app->set_registration_services($registration);
        $app->registration_middleware($middleware);
        $this->assertContains($middleware, \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($registration, 'middleware'));
    }
    /** @testdox If middleware is added before the registation service has been bound to the app, the system should return an error. */
    public function test_registration_middleware_exception() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(3);
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $middleware = $this->createMock(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\Registration_Middleware::class);
        $app->registration_middleware($middleware);
    }
    /** @testdox A list of classes which should be run through the registration process, should be able to stacked up ready to go. */
    public function test_registration_classes() : void
    {
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $registration = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Services\Registration\Registration_Service();
        $app->set_registration_services($registration);
        $app->registration_classes(array(\pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Application\Sample_Class::class));
        $this->assertContains(\pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Application\Sample_Class::class, \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($registration, 'class_list'));
    }
    /** @testdox If classes are set for registration before the service has been bound to the application, it should error and abort initialisation. */
    public function test_registration_classes_exception() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(3);
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $app->registration_classes(array(\pc_pink_pos_0_0_1\PinkCrab\Perique\Tests\Application\Sample_Class::class));
    }
    /** @testdox When a fully populated app is booted, it should pass valdaition and run all internal setups. */
    public function test_boot() : void
    {
        $app = $this->pre_populated_app_provider();
        // Ensure app is not marked as booted before calling boot()
        $this->assertFalse($app::is_booted());
        $app->boot();
        // Check the app has been booted and container is bound to registration.
        $this->assertTrue($app::is_booted());
        $registration = \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($app, 'registration');
        $this->assertInstanceOf(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container::class, \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($registration, 'di_container'));
    }
    /** @testdox The app should only be bootable only once, trying to reboot should cause an error and abort the request. */
    public function test_throws_exception_if_trying_to_boot_twice() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(6);
        $app = $this->pre_populated_app_provider();
        $app->boot();
        $app->boot();
    }
    /** @testdox The apps internal serives (View, DI & App_Config) can only be used once the application has been booted. */
    public function test_throws_exception_if_view_is_called_before_app_booted() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(4);
        $app = $this->pre_populated_app_provider();
        $app::view();
    }
    /** @testdox It should be possible to access the current DI container from the App instance, for use in additional libraies that need access. */
    public function test_can_get_container_from_app() : void
    {
        $app = $this->pre_populated_app_provider();
        $this->assertInstanceOf(\pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\DI_Container::class, $app->get_container());
    }
    /** @testdox Attemptingt to access the DI Container before it has been defiend, should resutl in an Application Intialization exception. */
    public function test_throws_exception_if_attempting_to_access_undefined_di_container() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception::class);
        $this->expectExceptionCode(1);
        $app = new \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\App();
        $app->get_container();
    }
    /** @testdox It should be possible to access App_Config using the Config Facade */
    public function test_config_facade() : void
    {
        $app = $this->pre_populated_app_provider();
        $app->boot();
        $this->assertEquals(FIXTURES_PATH . '/Views/', \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\Config::path('view'));
        $this->assertEquals('test_value', \pc_pink_pos_0_0_1\PinkCrab\Perique\Application\Config::additional('test_key'));
    }
}
