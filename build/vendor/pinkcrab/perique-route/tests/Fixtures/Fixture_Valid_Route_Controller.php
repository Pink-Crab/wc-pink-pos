<?php

declare (strict_types=1);
/**
 * Base class for Rest Integration tests.
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
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Route
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Route\Tests\Fixtures;

use pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Controller;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Factory;
use pc_pink_pos_0_0_1\WP_HTTP_Response;
class Fixture_Valid_Route_Controller extends \pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Controller
{
    /**
     * The namespace for this controllers routes
     *
     * @required
     * @var string
     */
    protected $namespace = 'pinkcrab/v3';
    /**
     * Method defined to register all routes.
     *
     * @param Route_Factory $factory
     * @return array<Route|Route_Group>
     */
    protected function define_routes(\pc_pink_pos_0_0_1\PinkCrab\Route\Route_Factory $factory) : array
    {
        return [$factory->get('valid-get', [$this, 'get_callback']), $factory->group_builder('valid-group', function (\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group $group) {
            $group->post([$this, 'post_callback']);
            $group->delete([$this, 'delete_callback']);
            return $group;
        })];
    }
    // CALLBACKS
    public function get_callback($request) : \WP_HTTP_Response
    {
        return new \WP_HTTP_Response(['method' => 'get']);
    }
    public function post_callback($request) : \WP_HTTP_Response
    {
        return new \WP_HTTP_Response(['method' => 'post']);
    }
    public function delete_callback($request) : \WP_HTTP_Response
    {
        return new \WP_HTTP_Response(['method' => 'delete']);
    }
}
