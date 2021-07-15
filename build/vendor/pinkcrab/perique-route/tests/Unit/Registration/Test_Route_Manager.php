<?php

declare (strict_types=1);
/**
 * Unit Tests for Route_Manager
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
namespace pc_pink_pos_0_0_1\PinkCrab\Route\Tests\Unit\Registration;

use pc_pink_pos_0_0_1\WP_UnitTestCase;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route;
use pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Loader;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Argument;
use pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group;
use pc_pink_pos_0_0_1\PinkCrab\Route\Registration\Route_Manager;
use pc_pink_pos_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Exception;
class Test_Route_Manager extends \WP_UnitTestCase
{
    /** @var Route_Manager */
    protected $route_manager;
    function setUp() : void
    {
        parent::setUp();
        $this->route_manager = new \pc_pink_pos_0_0_1\PinkCrab\Route\Registration\Route_Manager(new \pc_pink_pos_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar(), new \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Loader());
    }
    /**
     * Returns a basic route group with post and get methods.
     *
     * @return \PinkCrab\Route\Route\Route_Group
     */
    public static function basic_group_provider() : \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group
    {
        $group = new \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group('acme', '/route');
        $group->get('is_string')->argument(\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Argument::on('id')->type('string'))->authentication('is_string');
        $group->post('is_array')->authentication('is_array');
        $group->authentication('is_bool');
        $group->argument(\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Argument::on('id')->type('boolean'));
        return $group;
    }
    /** @testdox It should be possible to create partially populated route based on the values set in the group. */
    public function test_can_create_base_route_from_group() : void
    {
        $group = self::basic_group_provider();
        $route = \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($this->route_manager, 'create_base_route_from_group', array('GET', $group));
        $this->assertEquals('/route', $route->get_route());
        $this->assertEquals('acme', $route->get_namespace());
        $this->assertEquals('GET', $route->get_method());
        $this->assertTrue($route->has_argument('id'));
        $this->assertContains('is_bool', $route->get_authentication());
    }
    /** @testdox When a group is registered, each route within the group should be populate each route using the base values from the group.  */
    public function test_can_unpack_group() : void
    {
        $group = self::basic_group_provider();
        $routes = \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($this->route_manager, 'unpack_group', array($group));
        $this->assertIsArray($routes);
        $this->assertArrayHasKey('GET', $routes);
        $this->assertArrayHasKey('POST', $routes);
        // Check the get, should have replaced the argument for ID and stacked auth callbacks
        $get = $routes['GET'];
        $this->assertEquals('/route', $get->get_route());
        $this->assertEquals('acme', $get->get_namespace());
        $this->assertEquals('GET', $get->get_method());
        $this->assertCount(2, $get->get_authentication());
        $this->assertContains('is_bool', $get->get_authentication());
        $this->assertContains('is_string', $get->get_authentication());
        $this->assertTrue($get->has_argument('id'));
        $argument = $get->get_arguments();
        $this->assertEquals('id', $argument['id']->get_key());
        $this->assertEquals('string', $argument['id']->get_type());
        // As per route definition.
        // Check the post, should have NOT replaced the argument for ID and stacked auth callbacks
        $post = $routes['POST'];
        $this->assertEquals('/route', $post->get_route());
        $this->assertEquals('acme', $post->get_namespace());
        $this->assertEquals('POST', $post->get_method());
        $this->assertCount(2, $post->get_authentication());
        $this->assertContains('is_bool', $post->get_authentication());
        $this->assertContains('is_array', $post->get_authentication());
        $this->assertTrue($post->has_argument('id'));
        $argument = $post->get_arguments();
        $this->assertEquals('id', $argument['id']->get_key());
        $this->assertEquals('boolean', $argument['id']->get_type());
        // As per group definition
    }
    /** @testdox If a group is created that has a route/method with no callback defined, an eror should be thrown and the registration process ended. */
    public function test_throws_exception_if_route_has_no_callback() : void
    {
        $this->expectException(\pc_pink_pos_0_0_1\PinkCrab\Route\Route_Exception::class);
        $this->expectExceptionCode(102);
        // Create a group with a route that has no callback.
        $group = new \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group('namespace', 'no-callback');
        \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::set_property($group, 'routes', ['GET' => new \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route('GET', 'ignore')]);
        // Attempt to unpack
        \pc_pink_pos_0_0_1\Gin0115\WPUnit_Helpers\Objects::invoke_method($this->route_manager, 'unpack_group', array($group));
    }
}
