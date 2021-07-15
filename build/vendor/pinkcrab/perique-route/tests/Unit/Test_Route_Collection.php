<?php

declare (strict_types=1);
/**
 * Tests for the Route Collection
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
namespace pc_pink_pos_0_0_1\PinkCrab\Route\Tests\Unit;

use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Collection;
use stdClass;
use pc_pink_pos_0_0_1\WP_UnitTestCase;
class Test_Route_Collection extends \WP_UnitTestCase
{
    /** @testdox It should only be possible to pass Route and Route_Groups to a Route_Collection  */
    public function test_only_accepts_routes() : void
    {
        $route1 = new \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route('GET', 'route');
        $route2 = new \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route('POST', 'route');
        $group = new \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group('acme', 'route');
        $collection = new \pc_pink_pos_0_0_1\PinkCrab\Route\Route_Collection([$route1, new \stdClass()]);
        $collection->push($route2);
        $collection->add_route($group);
        $collection->push(new \stdClass());
        $this->assertCount(3, $collection);
        $this->assertContains($route1, $collection->to_array());
        $this->assertContains($route2, $collection->to_array());
        $this->assertContains($group, $collection->to_array());
    }
}
