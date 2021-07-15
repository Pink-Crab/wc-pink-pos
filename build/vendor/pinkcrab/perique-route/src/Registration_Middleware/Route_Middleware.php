<?php

declare (strict_types=1);
/**
 * Route Dispatcher Middleware
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Route
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware;

use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Collection;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Abstract_Route;
use pc_pink_pos_0_0_1\PinkCrab\Route\Schema\Abstract_Type;
use pc_pink_pos_0_0_1\PinkCrab\Route\Registration\Route_Manager;
use pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\Registration_Middleware;
use pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Controller;
class Route_Middleware implements \pc_pink_pos_0_0_1\PinkCrab\Perique\Interfaces\Registration_Middleware
{
    /** @var Route_Manager */
    protected $route_manager;
    public function __construct(\pc_pink_pos_0_0_1\PinkCrab\Route\Registration\Route_Manager $route_manager)
    {
        $this->route_manager = $route_manager;
    }
    /**
     * Add all valid route calls to the dispatcher.
     *
     * @param object|Route_Controller $class
     * @return object
     */
    public function process($class)
    {
        if (\is_a($class, \pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Controller::class)) {
            $routes = $class->get_routes(new \pc_pink_pos_0_0_1\PinkCrab\Route\Route_Collection());
            $routes->each(function (\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Abstract_Route $route) {
                if (\is_a($route, \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route::class)) {
                    $this->route_manager->from_route($route);
                    return;
                }
                if (\is_a($route, \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group::class)) {
                    $this->route_manager->from_group($route);
                    return;
                }
            });
        }
        return $class;
    }
    public function setup() : void
    {
        /*noOp*/
    }
    /**
     * Register all routes with WordPress calls.
     *
     * @return void
     */
    public function tear_down() : void
    {
        $this->route_manager->execute();
    }
}
