<?php
/**
 * slim index
 *
 * @package index
 * @author np <np.liamg@gmail.com>
 * @version 0.1
 * @copyright (C) 2020 np <np.liamg@gmail.com>
 * @license MIT
 */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src-php/bootstrap.php';
$app = AppFactory::create();

$router = function (Request $request, Response $response, $args) {
    $args['__controller'] = $args["__controller"] ?? 'Home';
    $args['__action'] = $args["__action"] ?? 'index';
    $controllerName = 'App\\Controller\\' . ucwords($args["__controller"]);
    $actionName = $args['__action'];
    unset($args['__controller']);
    unset($args['__action']);
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $actionName)) {
            $response = $controller->$actionName($request, $response, $args);
            return $response;
        }
    }
    $response->getBody()->write("Can't find $controllerName::$actionName");
    return $response->withStatus(404);
};

//todo 没用可以删除
$router404 = function (Request $request, Response $response, $args) {
    $response->getBody()->write("Can't find page");
    return $response->withStatus(404);
};

// todo 处理尾部斜线。统一跳转至无尾部斜线的 url
$app->any('/{__controller}[/]', $router);
$app->any('/{__controller}/{__action}[/{params:.*}]', $router);
$app->any('/', $router);
$app->run();
