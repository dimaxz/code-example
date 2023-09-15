<?php
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * @var \League\Container\Container $container
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Dotenv setup
 */
$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(BASEPATH);
$dotenv->load();


/**
 * Error handler
 */
$whoops = new Run;
if (getenv('MODE') === 'dev') {
    error_reporting(-1);
    ini_set('display_errors', 1);
    $whoops->pushHandler(new PrettyPageHandler);
} else {
    ini_set('display_errors', 0);
    if (version_compare(PHP_VERSION, '5.3', '>='))
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
    }
    else
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
    }
    $whoops->pushHandler(function () {
        Response::create('Uh oh, something broke internally.', Response::HTTP_INTERNAL_SERVER_ERROR)->send();
    });
}
$whoops->register();

//Propel2 config
require_once __DIR__ . '/config.php';

require_once __DIR__ . '/container.php';


/**
 * Routes
 */
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $routes = require __DIR__ . '/routes.php';
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
});



/**
 * Dispatch
 */
$response = null;
$request = Request::createFromGlobals();
$route_info = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

switch ($route_info[0]) {
    case Dispatcher::NOT_FOUND:
        $response = new Response("404 Not Found", Response::HTTP_NOT_FOUND);
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response = new Response("405 Method Not Allowed", Response::HTTP_METHOD_NOT_ALLOWED);
        break;
    case Dispatcher::FOUND:
        $class_name = $route_info[1][0];
        $method = $route_info[1][1];
        $vars = $route_info[2];
        $object = $container->get($class_name);

        $result = $object->$method($vars);
        if ($result instanceof Response) {
            $response = $result;
            $response->prepare(Request::createFromGlobals());
        }
        else{
            $response = new Response($result);
        }

        break;
}

if($response){

    $response->send();
}
