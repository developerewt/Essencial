<?php

use Essencial\ServiceContainer;
use Essencial\Application;
use Essencial\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use Essencial\View\View;
use Essencial\Database\Database;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new Router());
$app->plugin(new View());
$app->plugin(new Database());

$app->get('/{name}', function(ServerRequestInterface $request) use ($app) {

    $view = $app->service('view.renderer');
    return $view->render('index.html.twig', ['name' => $request->getAttribute('name')]);

});

$app->get('/home/{name}', function(ServerRequestInterface $request) {
    echo 'Hello World!!!';
    echo '<br>';
    echo $request->getAttribute('name');
});

$app->start();