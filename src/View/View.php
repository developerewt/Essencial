<?php

namespace Essencial\View;

use Essencial\Plugin\PluginInterface;
use Essencial\ServiceContainerInterface;
use Interop\Container\ContainerInterface;

class View implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
        $container->addLazy('twig', function(ContainerInterface $c) {
            $templates = __DIR__ . '/../../app/views';

            $loader = new \Twig_Loader_Filesystem($templates);
            $twig   = new \Twig_Environment($loader);
            return $twig;
        });

        $container->addLazy('view.renderer', function(ContainerInterface $c) {
            $twigEnvironment = $c->get('twig');
            return new ViewRender($twigEnvironment);
        });
    }

}