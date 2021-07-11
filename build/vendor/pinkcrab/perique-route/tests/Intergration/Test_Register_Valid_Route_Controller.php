<?php

declare (strict_types=1);
/**
 * Intergration tests for a valid route
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Route
 *
 */
namespace pinkcrab_cccp_0_0_1\PinkCrab\Route\Tests\Unit\Registration;

use pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects;
use pinkcrab_cccp_0_0_1\phpDocumentor\Reflection\Types\Void_;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App_Factory;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Controller;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Route_Collection;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Route_Exception;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Tests\Fixtures\Fixture_Valid_Route_Controller;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Tests\Fixtures\HTTP_TestCase;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Utils;
class Test_Register_Valid_Route_Controller extends \pinkcrab_cccp_0_0_1\PinkCrab\Route\Tests\Fixtures\HTTP_TestCase
{
    /** @testdox It should be possible to get the namespace from a route controller */
    public function test_can_get_namespace_from_controller() : void
    {
        $controller = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Tests\Fixtures\Fixture_Valid_Route_Controller();
        $this->assertEquals('pinkcrab/v3', \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($controller, 'get_namespace', []));
    }
    /** @testdox The route controller should self populate a factory using the defined namespace. */
    public function test_can_access_populated_factory() : void
    {
        $controller = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Tests\Fixtures\Fixture_Valid_Route_Controller();
        $factory = \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($controller, 'get_factory', []);
        $this->assertEquals('pinkcrab/v3', \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($factory, 'namespace'));
    }
    /** @testdox It should be possible to populate a route collection from a route controller. */
    public function test_get_routes() : void
    {
        $controller = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Tests\Fixtures\Fixture_Valid_Route_Controller();
        $collection = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Route_Collection();
        $controller->get_routes($collection);
        $this->assertCount(2, $collection);
    }
    /** @testdox If a controller has no namespace defined and exception should be thrown. */
    public function test_throws_exception_if_no_namespace_in_controller() : void
    {
        $mock_controller = $this->createMock(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Controller::class);
        $this->expectException(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route_Exception::class);
        \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($mock_controller, 'get_namespace', []);
    }
    /** @testdox When the middleware is added to the App and a valid controller is added to registration, the routes defined should be working. */
    public function test_as_app_middleware() : void
    {
        $middleware = \pinkcrab_cccp_0_0_1\PinkCrab\Route\Utils::middleware_provider();
        $app = (new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App_Factory())->with_wp_dice(\true)->app_config(array())->registration_middleware($middleware)->registration_classes(array(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Tests\Fixtures\Fixture_Valid_Route_Controller::class))->boot();
        // Trigger app intialisation
        do_action('init');
        // Extract the hooks from the dispatcher, from middleware
        $route_manager = \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($middleware, 'route_manager');
        $hook_loader = \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($route_manager, 'loader');
        $hooks = \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::get_property($hook_loader, 'hooks');
        $hooks = $hooks->export();
        // Check routes are registered from Hook Loader
        $this->assertTrue($hooks[0]->is_registered());
        $this->assertTrue($hooks[1]->is_registered());
        $this->assertTrue($hooks[2]->is_registered());
        // Check hooks on rest_api_init
        $this->assertEquals('rest_api_init', $hooks[0]->get_handle());
        $this->assertEquals('rest_api_init', $hooks[1]->get_handle());
        $this->assertEquals('rest_api_init', $hooks[2]->get_handle());
        // Initlaise the routes.
        $this->register_routes();
        // Check basic get
        $this->assertEquals(200, $this->dispatch_request('GET', '/pinkcrab/v3/valid-get')->get_status());
        // Check basic PUT not set.
        $this->assertEquals(404, $this->dispatch_request('PUT', '/pinkcrab/v3/valid-get')->get_status());
        // Check group post
        $this->assertEquals(200, $this->dispatch_request('POST', '/pinkcrab/v3/valid-group')->get_status());
        // Check group delete
        $this->assertEquals(200, $this->dispatch_request('DELETE', '/pinkcrab/v3/valid-group')->get_status());
    }
}
