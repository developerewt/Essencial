<?php
declare(strict_types=1);

namespace Essencial\Router;

use Essencial\Application;
use Psr\Http\Message\ResponseInterface;

interface ActionRouterInterface
{

    public function get($path, $action, $name = null): Application;

    public function post($path, $action, $name = null): Application;

    public function put();

    public function delete();

    public function patch();

    public function redirect($path): ResponseInterface;

}