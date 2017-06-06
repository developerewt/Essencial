<?php
declare(strict_types=1);
namespace Essencial\Router;

use Aura\Router\RouterContainer;
use Essencial\Plugin\PluginInterface;
use Essencial\ServiceContainerInterface;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\ServerRequestFactory;

class Router implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
		$router 	= new RouterContainer();
		$map 	    = $router->getMap();
		$matcher    = $router->getMatcher();

		$generator  = $router->getGenerator();
        $request    = $this->getRequest();

        $container->add('routing', $map);
        $container->add('routing.matcher', $matcher);
        $container->add('routing.generator', $generator);
        $container->add(RequestInterface::class, $request);

        $container->addLazy('route', function(ContainerInterface $c) {
		    $matcher = $c->get('routing.matcher');
		    $request = $c->get(RequestInterface::class);
		    return $matcher->match($request);
        });
    }

    protected function getRequest(): RequestInterface
    {
        return ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
    }


}
