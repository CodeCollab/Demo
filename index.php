<?php declare(strict_types=1);

use CodeCollab\Router\Router;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std as RouteParser;
use FastRoute\DataGenerator\GroupCountBased as RouteDataGenerator;

/**
 * Setup the project autoloader
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Setup the router
 */
$routeCache     = '/cache/routes.php';
$routeCollector = new RouteCollector(new RouteParser(), new RouteDataGenerator());

$router = new Router($routeCollector);

$router->addRoute('GET', '/not-found', ['Demo\Presentation\Controller\Error', 'notFound']);
