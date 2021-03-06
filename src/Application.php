<?php

declare(strict_types=1);

namespace Essencial;

use Essencial\Plugin\PluginInterface;
use Essencial\Router\ActionRouterInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\SapiEmitter;

class Application implements ActionRouterInterface
{
    /**
     * @var ServiceContainerInterface
     */
    private $serviceContainer;

    /**
     * Application constructor.
     *
     * @param ServiceContainerInterface $serviceContainer
     */
    public function __construct(ServiceContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function service($name)
    {
        return $this->serviceContainer->get($name);
    }

    /**
     * @param string $name
     * @param        $service
     */
    public function addService(string $name, $service): void
    {
        if (is_callable($service)) {
            $this->serviceContainer->addLazy($name, $service);
        } else {
            $this->serviceContainer->add($name, $service);
        }
    }

    /**
     * @param PluginInterface $plugin
     */
    public function plugin(PluginInterface $plugin): void
    {
        $plugin->register($this->serviceContainer);
    }

    public function start()
    {
        $route = $this->serviceContainer->get('route');
        /**
         * @var ServerRequestInterface $request
         *
         */
        $request = $this->service(RequestInterface::class);

        if (!$route) {
            echo 'Page not found!';
            exit;
        }

        foreach ($route->attributes as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }

        $callable = $route->handler;
        $response = $callable($request);
        $this->emitResponse($response);
    }

    protected function emitResponse(ResponseInterface $response)
    {
        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }

    public function get($path, $action, $name = null): Application
    {
        $routing = $this->serviceContainer->get('routing');
        $routing->get($name, $path, $action);

        return $this;
    }

    public function post($path, $action, $name = null): Application
    {
        $routing = $this->serviceContainer->get('routing');
        $routing->post($name, $path, $action);

        return $this;
    }

    public function put()
    {

    }

    public function delete()
    {

    }

    public function patch()
    {

    }

    public function redirect($path): ResponseInterface
    {
        return new RedirectResponse($path);
    }

}

