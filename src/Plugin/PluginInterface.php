<?php

namespace Essencial\Plugin;


use Essencial\ServiceContainerInterface;

interface PluginInterface
{

    public function register(ServiceContainerInterface $serviceContainer);

}