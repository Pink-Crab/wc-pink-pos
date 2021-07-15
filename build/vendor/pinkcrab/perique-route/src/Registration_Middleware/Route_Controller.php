<?php

declare (strict_types=1);
/**
 * Abstract Route Controller
 *
 * @package PinkCrab\Route\Route
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware;

use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Factory;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Exception;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Collection;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route_Group;
abstract class Route_Controller
{
    /**
     * The namespace for this controllers routes
     *
     * @required
     * @var string
     */
    protected $namespace;
    /**
     * Returns the controllers namespace
     *
     * @return string
     * @throws Route_Exception (code 101)
     */
    private final function get_namespace() : string
    {
        if (!\is_string($this->namespace) || \mb_strlen($this->namespace) === 0) {
            throw \pc_pink_pos_0_0_1\PinkCrab\Route\Route_Exception::namespace_not_defined(\get_class($this));
        }
        return $this->namespace;
    }
    /**
     * Returns a factory for this controller.
     *
     * @return Route_Factory
     * @throws Route_Exception (code 101)
     */
    private final function get_factory() : \pc_pink_pos_0_0_1\PinkCrab\Route\Route_Factory
    {
        return \pc_pink_pos_0_0_1\PinkCrab\Route\Route_Factory::for($this->get_namespace());
    }
    /**
     * Adds all routes defined to the passed route collection.
     *
     * @param Route_Collection $collection
     * @return Route_Collection
     */
    public final function get_routes(\pc_pink_pos_0_0_1\PinkCrab\Route\Route_Collection $collection) : \pc_pink_pos_0_0_1\PinkCrab\Route\Route_Collection
    {
        $routes = $this->define_routes($this->get_factory());
        foreach ($routes as $route) {
            $collection->add_route($route);
        }
        return $collection;
    }
    /**
     * Method defined to register all routes.
     *
     * @param Route_Factory $factory
     * @return array<Route|Route_Group>
     */
    protected abstract function define_routes(\pc_pink_pos_0_0_1\PinkCrab\Route\Route_Factory $factory) : array;
}
