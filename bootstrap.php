<?php declare(strict_types=1);
/**
 * Bootstrap of the project
 *
 * PHP version 7.0
 *
 * @category   Demo
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://pieterhordijk.com>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace Demo;

use CodeCollab\Http\Request\Request;
use CodeCollab\Http\Response\Response;
use CodeCollab\Http\Session\Native as Session;
use CodeCollab\Authentication\User;
use CodeCollab\Encryption\Defuse\Decryptor;
use CodeCollab\Router\Router;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std as RouteParser;
use FastRoute\DataGenerator\GroupCountBased as RouteDataGenerator;
use FastRoute\Dispatcher\GroupCountBased as RouteDispatcher;
use CodeCollab\Router\Injector;
use CodeCollab\Router\FrontController;
use CodeCollab\Theme\Theme;
use CodeCollab\I18n\FileTranslator;
use Minifine\Factory as MinifineFactory;
use Auryn\Injector as Auryn;

/**
 * Setup the project autoloader
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Setup the environment
 */
require_once __DIR__ . '/init.deployment.php';

/**
 * Prevent further execution when on CLI
 */
if (php_sapi_name() === 'cli') {
    return;
}

/**
 * Setup decryptor
 */
$decryptor = new Decryptor(file_get_contents(__DIR__ . '/encryption.key'));

/**
 * Setup the request object
 */
$request = new Request($decryptor, $_SERVER, $_GET, $_POST, $_FILES, $_COOKIE, file_get_contents('php://input'));

/**
 * Setup the session
 */
$session = new Session('/', $request->server('SERVER_NAME'), $request->isEncrypted());

/**
 * Setup authentication object
 */
$user = new User($session);

/**
 * Setup the router
 */
$routeCache     = $user->isLoggedIn() ? '/cache/routes-authenticated.php' : '/cache/routes.php';
$routeCollector = new RouteCollector(new RouteParser(), new RouteDataGenerator());

$router = new Router($routeCollector, function($dispatchData) {
    return new RouteDispatcher($dispatchData);
}, __DIR__ . $routeCache, !$production);

/**
 * Load routes
 */
require_once __DIR__ . '/routes.php';

/**
 * Setup the theme
 */
$theme = new Theme(__DIR__ . '/themes', 'Default');

/**
 * Setup i18n
 */
$translator = new FileTranslator(__DIR__ . '/texts', 'en_US');

/**
 * Setup the minifier
 */
$minifier = (new MinifineFactory())->build(__DIR__ . '/public', $production);

/**
 * Setup DI
 */
$auryn    = new Auryn();
$injector = new Injector($auryn);

/**
 * Setup shared instances and aliases
 */
$auryn->share($request);
$auryn->share($session);
$auryn->share($user);
$auryn->share($minifier);
$auryn->share($translator);
$auryn->share($decryptor);
$auryn->define('CodeCollab\Encryption\Defuse\Encryptor', [':key' => file_get_contents(__DIR__ . '/encryption.key')]);
$auryn->define('CodeCollab\Http\Cookie\Factory', [':domain' => $request->server('SERVER_NAME'), ':secure' => $request->isEncrypted()]);
$auryn->define('CodeCollab\Theme\Theme', [':themePath' => __DIR__ . '/themes', ':theme' => 'Default']);
$auryn->define('Demo\Presentation\Template\Html', [':basePage' => '/page.phtml']);
$auryn->alias('CodeCollab\CsrfToken\Token', 'CodeCollab\CsrfToken\Handler');
$auryn->alias('CodeCollab\Authentication\Authentication', 'CodeCollab\Authentication\User');
$auryn->alias('CodeCollab\CsrfToken\Storage\Storage', 'Demo\Storage\TokenSession');
$auryn->alias('CodeCollab\Http\Session\Session', 'CodeCollab\Http\Session\Native');
$auryn->alias('CodeCollab\CsrfToken\Generator\Generator', 'CodeCollab\CsrfToken\Generator\RandomBytes32');
$auryn->alias('CodeCollab\I18n\Translator', 'CodeCollab\I18n\FileTranslator');
$auryn->alias('CodeCollab\Theme\Loader', 'CodeCollab\Theme\Theme');
$auryn->alias('CodeCollab\Template\Html', 'Demo\Presentation\Template\Html');
$auryn->alias('CodeCollab\Encryption\Encryptor', 'CodeCollab\Encryption\Defuse\Encryptor');
$auryn->alias('CodeCollab\Encryption\Decryptor', 'CodeCollab\Encryption\Defuse\Decryptor');

/**
 * Setup the front controller
 */
$frontController = new FrontController(
    $router,
    $auryn->make('CodeCollab\Http\Response\Response', ['server' => $request]),
    $session,
    $injector
);

/**
 * Run the application
 */
$frontController->run($request);
