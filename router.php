<?php

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/trending', [\App\Controller\Controller::class, "trending"]);
    $r->addRoute('GET', '/random', [\App\Controller\Controller::class, "random"]);
    $r->addRoute('GET', '/', [\App\Controller\Controller::class, "search"]);
    $r->addRoute('GET', '/home', [\App\Controller\Controller::class, "home"]);

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $class = new $handler[0]();
        $method = $handler[1];
        $response = $class->$method();
        echo $response;
        break;
}
