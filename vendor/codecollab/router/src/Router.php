<?php declare(strict_types=1);
/**
 * The router class
 *
 * This router defines routes based on nikic's FastRoute project
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Router
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace CodeCollab\Router;

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

/**
 * The router class
 *
 * @category   CodeCollab
 * @package    Router
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Router
{
    /**
     * @param \FastRoute\RouteCollector Collector for routes defined in the system
     */
    private $routeCollector;

    /**
     * @param callable Factory for the dispatcher
     */
    private $dispatcherFactory;

    /**
     * @param string Filename of the cache file
     */
    private $cacheFile;

    /**
     * @param bool Whether to invalidate and reload the cache
     */
    private $forceReload;

    /**
     * Creates instance
     *
     * @param \FastRoute\RouteCollector $routeCollector    Collector for routes defined in the system
     * @param callable                  $dispatcherFactory Factory for the dispatcher
     * @param string                    $cacheFile         Filename of the cache file
     * @param bool                      $forceReload       Whether to invalidate and reload the cache
     */
    public function __construct(
        RouteCollector $routeCollector,
        callable $dispatcherFactory,
        string $cacheFile,
        bool $forceReload = false
    )
    {
        $this->routeCollector    = $routeCollector;
        $this->dispatcherFactory = $dispatcherFactory;
        $this->cacheFile         = $cacheFile;
        $this->forceReload       = $forceReload;
    }

    /**
     * Adds a route
     *
     * @param string $verb     The HTTP verb of the route
     * @param string $path     The pattern of the path of the route
     * @param array  $callback The callback of the route
     *
     * @return \CodeCollab\Router\Router Return instance of itself to create a fluent interface
     */
    public function addRoute(string $verb, string $path, array $callback): Router
    {
        $this->routeCollector->addRoute($verb, $path, $callback);
//echo '<pre>';
//var_dump([$verb, $path, $callback]);
        return $this;
    }
}
