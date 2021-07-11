<?php

declare (strict_types=1);
/**
 * Unit Tests for WP_Route_Registrar
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

use pinkcrab_cccp_0_0_1\WP_UnitTestCase;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Route;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Argument;
use pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration\WP_Rest_Route;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar;
use pinkcrab_cccp_0_0_1\PinkCrab\Route\Route_Exception;
class Test_WP_Rest_Registrar extends \WP_UnitTestCase
{
    /** @testdox When registering a route, the args array for register_rest_route() should be compiled from the Route object. */
    public function test_can_parse_options_with_args() : void
    {
        $route = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Route('GET', 'test');
        $route->namespace('NS');
        $route->authentication('is_array');
        $route->callback('is_string');
        $route->argument(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Argument::on('id')->type(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Argument::TYPE_STRING)->sanitization('is_null')->validation('is_object')->required()->default('bacon'));
        $route->argument(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Argument::on('all')->type(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Argument::TYPE_NUMBER)->sanitization('is_bool')->validation('is_array')->required(\false)->description('Description All')->format(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Argument::FORMAT_URL)->expected('tree', 'car')->default(12)->minimum(1)->exclusive_minimum()->maximum(45)->exclusive_maximum());
        $registrar = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar();
        $wp_route_args = \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($registrar, 'parse_options', array($route));
        // Basic Options
        $this->assertEquals('GET', $wp_route_args['methods']);
        $this->assertEquals('is_string', $wp_route_args['callback']);
        $this->assertEquals('is_array', $wp_route_args['permission_callback']);
        // Args
        $this->assertCount(2, $wp_route_args['args']);
        $this->assertArrayHasKey('id', $wp_route_args['args']);
        $this->assertArrayHasKey('all', $wp_route_args['args']);
        $id_args = $wp_route_args['args']['id'];
        $this->assertCount(5, $id_args);
        $this->assertEquals('is_object', $id_args['validate_callback']);
        $this->assertEquals('is_null', $id_args['sanitize_callback']);
        $this->assertEquals('string', $id_args['type']);
        $this->assertTrue($id_args['required']);
        $this->assertEquals('bacon', $id_args['default']);
        $all_args = $wp_route_args['args']['all'];
        $this->assertCount(12, $all_args);
        $this->assertEquals('is_array', $all_args['validate_callback']);
        $this->assertEquals('is_bool', $all_args['sanitize_callback']);
        $this->assertEquals('number', $all_args['type']);
        $this->assertEquals('url', $all_args['format']);
        $this->assertEquals('Description All', $all_args['description']);
        $this->assertFalse($all_args['required']);
        $this->assertEquals(12, $all_args['default']);
        $this->assertIsArray($all_args['enum']);
        $this->assertContains('tree', $all_args['enum']);
        $this->assertContains('car', $all_args['enum']);
        $this->assertEquals(1, $all_args['minimum']);
        $this->assertTrue($all_args['minimumExclusive']);
        $this->assertEquals(45, $all_args['maximum']);
        $this->assertTrue($all_args['maximumExclusive']);
    }
    /** @testdox It should be possible to set multiple permission/auth callbacks and have the requirement to have all the need to pass (true) */
    public function test_compose_permission_callback() : void
    {
        $route = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Route('GET', 'test');
        $registrar = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar();
        // Any value should pass.
        $callback = \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($registrar, 'compose_permission_callback', array($route));
        $this->assertTrue($callback(12));
        $this->assertTrue($callback(\false));
        // Set to allow any numeric
        $route->authentication('is_numeric');
        $callback = \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($registrar, 'compose_permission_callback', array($route));
        $this->assertTrue($callback(12));
        $this->assertTrue($callback('12'));
        $this->assertFalse($callback(\false));
        // Stack additional check
        $route->authentication('is_int');
        $callback = \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($registrar, 'compose_permission_callback', array($route));
        $this->assertTrue($callback(12));
        $this->assertFalse($callback('12'));
        $this->assertFalse($callback(\false));
    }
    /** @testdox It should be possible to map a Route object to a format for using with wordpress */
    public function test_can_map_from_route_wp_rest() : void
    {
        $route = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Route('PUT', 'test');
        $route->namespace('NS');
        $route->authentication('is_array');
        $route->callback('is_string');
        $route->argument(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Argument::on('key')->type(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Argument::TYPE_STRING)->sanitization('is_int')->validation('esc_html')->required()->default('<empty>'));
        $registrar = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar();
        $wp_route = $registrar->map_to_wp_rest($route);
        $this->assertInstanceOf(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration\WP_Rest_Route::class, $wp_route);
        $this->assertEquals('NS', $wp_route->namespace);
        $this->assertEquals('test', $wp_route->route);
        $this->assertIsArray($wp_route->args);
        $this->assertCount(4, $wp_route->args);
    }
    /** @testdox Attempting to register a route with no callback defined should result in an error. */
    public function test_throws_exception_if_no_callback_defined() : void
    {
        $this->expectException(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route_Exception::class);
        $this->expectExceptionCode(102);
        $registrar = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar();
        $route = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Route('PUT', 'test');
        \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($registrar, 'parse_options', array($route));
    }
    /** @testdox Attempting to register a route with an invalid method defined should result in an error. */
    public function test_throws_exception_for_invalid_method() : void
    {
        $this->expectException(\pinkcrab_cccp_0_0_1\PinkCrab\Route\Route_Exception::class);
        $this->expectExceptionCode(103);
        $registrar = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar();
        $route = new \pinkcrab_cccp_0_0_1\PinkCrab\Route\Route\Route('INVALID', 'test');
        $route->callback('is_string');
        \pinkcrab_cccp_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($registrar, 'parse_options', array($route));
    }
}
