<?php

declare (strict_types=1);
/**
 * General utility functions
 *
 * @package PinkCrab\Route\Route
 * @author Glynn Quelch glynn@pinkcrab.co.uk
 * @since 0.0.1
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Route;

use pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Loader;
use pc_pink_pos_0_0_1\PinkCrab\Route\Registration\Route_Manager;
use pc_pink_pos_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar;
use pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Middleware;
class Utils
{
    /**
     * Creates a single conditional function from many.
     * The passed value will be passed through each callbale,
     * if any result is not truthy, will return false.
     *
     * @param callable(mixed):bool ...$callables
     * @return callable(mixed):bool
     */
    public static function compose_conditional_all_true(callable ...$callables) : callable
    {
        return function ($value) use($callables) : bool {
            foreach ($callables as $callable) {
                $result = (bool) $callable($value);
                if (\true !== $result) {
                    return \false;
                }
            }
            return \true;
        };
    }
    /**
     * Creates a single conditional function from many.
     * The passed value will be passed through each callbale,
     * if any result is truthy, will return true, only false as a all failed..
     *
     * @param callable(mixed):bool ...$callables
     * @return callable(mixed):bool
     */
    public static function compose_conditional_any_true(callable ...$callables) : callable
    {
        return function ($value) use($callables) : bool {
            foreach ($callables as $callable) {
                $result = (bool) $callable($value);
                if (\true === $result) {
                    return \true;
                }
            }
            return \false;
        };
    }
    /**
     * Creates a single function, which pipes trough each callable in the order passed.
     *
     * @param callable(mixed):mixed ...$callables
     * @return callable(mixed):mixed
     */
    public static function compose_piped_callable(callable ...$callables) : callable
    {
        return function ($value) use($callables) {
            foreach ($callables as $callable) {
                $value = $callable($value);
            }
            return $value;
        };
    }
    /**
     * Provides a dependency populated instance of the Route Middleware.
     *
     * @return \PinkCrab\Route\Registration_Middleware\Route_Middleware
     */
    public static function middleware_provider() : \pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Middleware
    {
        return new \pc_pink_pos_0_0_1\PinkCrab\Route\Registration_Middleware\Route_Middleware(new \pc_pink_pos_0_0_1\PinkCrab\Route\Registration\Route_Manager(new \pc_pink_pos_0_0_1\PinkCrab\Route\Registration\WP_Rest_Registrar(), new \pc_pink_pos_0_0_1\PinkCrab\Loader\Hook_Loader()));
    }
}
