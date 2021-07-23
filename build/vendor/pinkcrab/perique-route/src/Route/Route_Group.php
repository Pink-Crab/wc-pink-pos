<?php

declare (strict_types=1);
/**
 * A custom file of function polyfills to get around php-scoper using global functions
 * in function_exist calls.
 *
 * This file should have the same namespace used in scoper.inc.php config.
 *
 * @package PinkCrab\Route
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Route\Route;

use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Factory;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route_Exception;
use pc_pink_pos_0_0_1\PinkCrab\Route\Route\Abstract_Route;
class Route_Group extends \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Abstract_Route
{
    /**
     * @var Route[]
     */
    protected $routes = array();
    /** @var Route_Factory */
    protected $route_factory;
    /**
     * @var string
     */
    protected $route;
    public function __construct(string $namespace, string $route)
    {
        $this->route = $route;
        $this->namespace = $namespace;
        $this->route_factory = new \pc_pink_pos_0_0_1\PinkCrab\Route\Route_Factory($namespace);
    }
    /**
     * Get the value of route
     *
     * @return string
     */
    public function get_route() : string
    {
        return $this->route;
    }
    /**
     * Creates a get request.
     *
     * @param callable $callable
     * @return Route
     */
    public function get(callable $callable) : \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route
    {
        $route = $this->route_factory->get($this->route, $callable);
        $route->namespace($this->namespace);
        $this->routes[\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route::GET] = $route;
        return $route;
    }
    /**
     * Creates a post request.
     *
     * @param callable $callable
     * @return Route
     */
    public function post(callable $callable) : \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route
    {
        $route = $this->route_factory->post($this->route, $callable);
        $route->namespace($this->namespace);
        $this->routes[\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route::POST] = $route;
        return $route;
    }
    /**
     * Creates a put request.
     *
     * @param callable $callable
     * @return Route
     */
    public function put(callable $callable) : \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route
    {
        $route = $this->route_factory->put($this->route, $callable);
        $route->namespace($this->namespace);
        $this->routes[\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route::PUT] = $route;
        return $route;
    }
    /**
     * Creates a patch  request.
     *
     * @param callable $callable
     * @return Route
     */
    public function patch(callable $callable) : \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route
    {
        $route = $this->route_factory->patch($this->route, $callable);
        $route->namespace($this->namespace);
        $this->routes[\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route::PATCH] = $route;
        return $route;
    }
    /**
     * Creates a delete  request.
     *
     * @param callable $callable
     * @return Route
     */
    public function delete(callable $callable) : \pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route
    {
        $route = $this->route_factory->delete($this->route, $callable);
        $route->namespace($this->namespace);
        $this->routes[\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route::DELETE] = $route;
        return $route;
    }
    /**
     * Adds a route ot the collection
     *
     * @param Route $route
     * @deprecated 0.0.2 This is not really used and should be removed in a future version.
     * @return self
     */
    public function add_rest_route(\pc_pink_pos_0_0_1\PinkCrab\Route\Route\Route $route) : self
    {
        $this->routes[$route->get_method()] = $route;
        return $this;
    }
    /**
     * Returns all the current routes.
     *
     * @return Route[]
     */
    public function get_rest_routes() : array
    {
        return $this->routes;
    }
    /**
     * Checks if a specific method is defined.
     *
     * @param string $method
     * @return bool
     */
    public function method_exists(string $method) : bool
    {
        return \array_key_exists(\strtoupper($method), $this->routes);
    }
    /**
     * Checks we have routes.
     *
     * @return bool
     */
    public function has_routes() : bool
    {
        return !empty($this->routes);
    }
}
