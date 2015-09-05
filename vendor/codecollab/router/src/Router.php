<?php declare(strict_types=1);

namespace CodeCollab\Router;

use FastRoute\RouteCollector;

class Router
{
    private $routeCollector;

    public function __construct(RouteCollector $routeCollector)
    {
        $this->routeCollector = $routeCollector;
    }

    public function addRoute(string $verb, string $path, array $callback): Router
    {
        $this->routeCollector->addRoute($verb, $path, $callback);

//var_dump($this); // object(CodeCollab\Router\Router)#5 (4) { ... }
        return $this;
    }
}
