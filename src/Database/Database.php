<?php

namespace Essencial\Database;

use Essencial\Plugin\PluginInterface;
use Essencial\ServiceContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
        $capsule    = new Capsule();
        $config     = include __DIR__ . '/../../config/database.php';
        $capsule->addConnection($config['development']);
        $capsule->bootEloquent();
    }

}