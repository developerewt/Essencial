<?php
/**
 * Created by PhpStorm.
 * User: esouza
 * Date: 04/06/17
 * Time: 23:57
 */

namespace Essencial;


use Xtreamwayz\Pimple\Container;

class ServiceContainer implements ServiceContainerInterface
{

    private $container;

    /**
     * ServiceContainer constructor.
     */
    public function __construct()
    {
        $this->container = new Container();
    }

    /**
     * @param string $name
     * @param        $service
     */
    public function add(string $name, $service)
    {
        $this->container[$name] = $service;
    }

    /**
     * @param string   $name
     * @param callable $callable
     */
    public function addLazy(string $name, callable $callable)
    {
        $this->container[$name] = $this->container->factory($callable);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->container->get($name);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name)
    {
        return $this->container->has($name);
    }
}