<?php

use Essencial\ServiceContainer;
use Essencial\Application;
use Essencial\Router\Router;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new Router());

$app->get('/', function(RequestInterface $request) {
    echo 'Hello World!!!';
});

$app->get('/home/{name}', function(ServerRequestInterface $request) {
    echo 'Hello World!!!';
    echo '<br>';
    echo $request->getAttribute('name');
});

$app->start();