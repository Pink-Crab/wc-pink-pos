<?php

declare (strict_types=1);
/**
 * Factory for creating standard instances of the App.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Perique
 * @since 0.4.0
 */
namespace pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application;

use pinkcrab_cccp_0_0_1\Dice\Dice;
use pinkcrab_cccp_0_0_1\PinkCrab\Loader\Hook_Loader;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Interfaces\Renderable;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Interfaces\DI_Container;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\View\PHP_Engine;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Dice\PinkCrab_Dice;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Interfaces\Registration_Middleware;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Exceptions\App_Initialization_Exception;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Registration\Registration_Service;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Registration\Middleware\Hookable_Middleware;
class App_Factory
{
    /**
     * The app instance.
     *
     * @var App
     */
    protected $app;
    public function __construct()
    {
        $this->app = new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App();
    }
    /**
     * Pre populates a standard instance of the App
     * Uses the PinkCrab_Dice container
     * Sets up registration and loader instances.
     * Adds Hookable Middleware
     *
     * Just requires Class List, Config and DI Rules.
     *
     * @return self
     */
    public function with_wp_dice(bool $include_default_rules = \false) : self
    {
        $loader = new \pinkcrab_cccp_0_0_1\PinkCrab\Loader\Hook_Loader();
        // Setup DI Container
        $container = \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Dice\PinkCrab_Dice::withDice(new \pinkcrab_cccp_0_0_1\Dice\Dice());
        if ($include_default_rules === \true) {
            $container->addRules($this->default_di_rules());
        }
        $this->app->set_container($container);
        // Set registration middleware
        $this->app->set_registration_services(new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Registration\Registration_Service());
        $this->app->set_loader($loader);
        // Include Hookable.
        $this->app->registration_middleware(new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\Registration\Middleware\Hookable_Middleware($loader));
        return $this;
    }
    /**
     * Returns the basic DI rules which are used to set.
     * WPDB
     * Renderable with PHP_Engine implementation
     *
     * @return array<mixed>
     */
    protected function default_di_rules() : array
    {
        return array('*' => array('substitutions' => array(\pinkcrab_cccp_0_0_1\PinkCrab\Perique\Interfaces\Renderable::class => new \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Services\View\PHP_Engine(__DIR__), \wpdb::class => $GLOBALS['wpdb'])));
    }
    /**
     * Set the DI rules
     *
     * @param array<string,array<string,string|object|callable|null|false|\Closure>> $rules
     * @return self
     */
    public function di_rules(array $rules) : self
    {
        $this->app->container_config(function (\pinkcrab_cccp_0_0_1\PinkCrab\Perique\Interfaces\DI_Container $container) use($rules) : void {
            $container->addRules($rules);
        });
        return $this;
    }
    /**
     * Sets the registration class list.
     *
     * @param array<int, string> $class_list Array of fully namespaced class names.
     * @return self
     */
    public function registration_classes(array $class_list) : self
    {
        $this->app->registration_classes($class_list);
        return $this;
    }
    /**
     * Sets the apps internal config
     *
     * @param array<string, mixed> $app_config
     * @return self
     */
    public function app_config(array $app_config) : self
    {
        $this->app->set_app_config($app_config);
        return $this;
    }
    /**
     * Returns the populated app.
     *
     * @return \PinkCrab\Perique\Application\App
     */
    public function app() : \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App
    {
        return $this->app;
    }
    /**
     * Returns a booted version of the app.
     *
     * @return \PinkCrab\Perique\Application\App
     */
    public function boot() : \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Application\App
    {
        // Sets default settings if not already set.
        if (!$this->app->has_app_config()) {
            $this->app_config(array());
        }
        return $this->app->boot();
    }
    /**
     * Add registration middleware
     *
     * @param Registration_Middleware $middleware
     * @return self
     * @throws App_Initialization_Exception Code 3
     */
    public function registration_middleware(\pinkcrab_cccp_0_0_1\PinkCrab\Perique\Interfaces\Registration_Middleware $middleware) : self
    {
        $this->app->registration_middleware($middleware);
        return $this;
    }
}
